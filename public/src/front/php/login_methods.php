<?php

require_once BASE_PATH_PUBLIC.'src/private/vars/encryption_vars.php';
require_once BASE_PATH_PUBLIC.'src/private/vars/login_vars.php';
require_once BASE_PATH_PUBLIC.'src/utils/php/other/get_client_ip.php';
require_once BASE_PATH_PUBLIC.'src/utils/php/cookie_management/auth_cookie.php';

function login_with_cookie($errors){

    // Initiate auth token verification diirective to false
    $isValidatorVerified = false;
    $isExpiryDateVerified = false;
    
    // Look for the selector in the db
    $selector_query = mysqli_prepare($GLOBALS['db'],
        "SELECT user_id, b.username, validator, expiry_date "
            . "FROM remember_auth AS a INNER JOIN users AS b ON a.user_id=b.id "
            . "WHERE selector=?");
    mysqli_stmt_bind_param($selector_query, "s", $_COOKIE["selector"]);
    mysqli_stmt_execute($selector_query);
    mysqli_stmt_bind_result($selector_query, $db_user_id, $db_username, $db_validator, $db_expiration);
    mysqli_stmt_fetch($selector_query);
    mysqli_stmt_close($selector_query);
    
    if (isset($db_username) && isset($db_validator)){
        // Register login attempt
        $errors = register_login_attempt($errors, $db_username);
        if (!$errors){
            // Are the validators the same?
            // We use hash_equals() instead of == because it protects against 
            // timing attacks.
            //  TODO Not sure if this is completely necessary in this setup
            if(hash_equals($db_validator, hash(VALIDATOR_ENCRYPT_ALGO, $_COOKIE["validator"]))){
                $isValidatorVerified = True;
            }
            // Check expiration date
            if($db_expiration <= time()){
                $isExpiryDateVerified = True;
            }
            
            if(!$isValidatorVerified){
                # PANIC! The user has the selector but not the validator!!! DELETE EVERYTHING!!!
                # TODO Should we take additional measures?
                delete_server_cookie($_COOKIE["selector"]);
                delete_user_cookie();
                $errors[] = "Cookie no reconocida";
            } else if (!$isExpiryDateVerified){
                # Delete the cookie for the db table. The user cannot access
                delete_server_cookie($_COOKIE["selector"]);
                delete_user_cookie();
                $errors[] = "Cookie caducada";
                
            } else {    # Everything when well
                # Update validator
                update_user_server_validator_cookie($selector);
            }
            
        }
    } else {
        $errors[] = "Cookie no reconocida";
        delete_user_cookie();
    }
    
    return $errors;
}

function login_with_credentials($errors){
    # We make sure we don't print anything so we can redirect the user to the game if needed
  $username = $_POST['username'];
  $password = $_POST['pass'];

  if (empty($username)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0){
      $errors = register_login_attempt($errors, $username);
  }
  
  if (count($errors) == 0) {
        
    // Let's get this user's encrypted pass
    try {
        $select_user_query = mysqli_prepare($GLOBALS['db'],
                "SELECT id, password FROM users WHERE username=?");

        mysqli_stmt_bind_param($select_user_query, "s", $username);
        mysqli_stmt_execute($select_user_query);
        mysqli_stmt_bind_result($select_user_query, $user_id, $hash_pass);
        mysqli_stmt_fetch($select_user_query);
        mysqli_stmt_close($select_user_query);

    } catch (Exception $e) {
        array_push($errors,'Problema con la base de datos. Por favor, intentelo de nuevo');
        return $errors;
    }  
    // What if the username does not exist?  
    if (is_null($hash_pass)){
        array_push($errors, "No existe ese usuario");
        return $errors;
    }  
    // Verify stored hash against plain-text password
    if (password_verify($password, $hash_pass)) {
        // Check if a newer hashing algorithm is available
        // or the cost has changed
        if (password_needs_rehash($hash_pass, ENCRYPT_ALGORITHM, ENCRYPT_OPTIONS)) {
            // If so, create a new hash, and replace the old one
            $newHash = password_hash($password, ENCRYPT_ALGORITHM, ENCRYPT_OPTIONS);
            // Update the database
            try {
                $update_pass_query = mysqli_prepare($GLOBALS['db'],
                    "UPDATE users SET password=? WHERE username = ?");
                mysqli_stmt_bind_param($update_pass_query, "ss", $hash_pass, $username);
                mysqli_stmt_execute($update_pass_query);
                mysqli_stmt_close($update_pass_query);

            } catch (Exception $e) {
                $errors[] = 'Problema actualizando la encriptación de contraseña. Intentelo de nuevo';
                return $errors;
            }
        }
        // Is the "Remember me" checkbox checked?
        if (isset($_POST['remember_me'])){
            # Create user cookie
            list($selector, $validator, $expiry_date) = create_user_cookie();
            # Store values in db
            create_server_cookie($user_id, $selector, $validator, $expiry_date);
            
        }
        
    } else {
        # If passwords didn't match
        array_push($errors, "La combinación 'Usuario-Contraseña' no es correcta.");
    }
  }
  return $errors;
}

function register_login_attempt($errors, $username){
    
    // Let's register this login try and check if there hasn't been many 
    // previous tries that already failed
    $register_try_query = mysqli_prepare($GLOBALS['db'],
            "INSERT INTO login_attempts (`username` ,`timestamp`) VALUES (?,CURRENT_TIMESTAMP)");
    mysqli_stmt_bind_param($register_try_query, "s", $username);
    mysqli_stmt_execute($register_try_query);
    mysqli_stmt_close($register_try_query);

    $count_tries_query = mysqli_prepare($GLOBALS['db'],
            "SELECT COUNT(*) FROM login_attempts "
            . "WHERE username=? AND `timestamp` > (now() - interval 10 minute)");
    mysqli_stmt_bind_param($count_tries_query, "s", $username);
    mysqli_stmt_execute($count_tries_query);
    mysqli_stmt_bind_result($count_tries_query, $attempts);
    mysqli_stmt_store_result($count_tries_query);
    mysqli_stmt_fetch($count_tries_query);
    if (isset($attempts) && $attempts > MAX_NUMBER_OF_ATTEMPTS){
        $errors[] = "Solo se permiten ".MAX_NUMBER_OF_ATTEMPTS." intentos cada 10 minutos.";
    } else {
        $register_try_query = mysqli_prepare($GLOBALS['db'],
                "DELETE FROM login_attempts "
                . "WHERE username=?");
        mysqli_stmt_bind_param($register_try_query, "s", $username);
        mysqli_stmt_execute($register_try_query);
        mysqli_stmt_close($register_try_query);
    }
    mysqli_stmt_close($count_tries_query);
    
    return $errors;
}



function log_user_in($user_id, $username){
    //Register log in          
    list($forwarded, $user_ip) = get_client_ip();
    $insert_login_query = mysqli_prepare($GLOBALS['db'],
    "INSERT INTO connections(user_id, ip, forwarded, date) VALUES (?,?,?,?)");
    mysqli_stmt_bind_param($insert_login_query, "isis", $user_id, $user_ip, $forwarded, date('Y-m-d G:i:s'));
    mysqli_stmt_execute($insert_login_query);
    mysqli_stmt_close($insert_login_query);
    // Create session
    session_start(); 
    $_SESSION['username'] = $username;
    $_SESSION['user_id'] = $user_id;
    header('location: ../game/profile/index.php?login=1');
            
}