<?php 
session_start(); 
require '../../private/db_connect.php';
require '../../utils/php/other/verify_user.php';
require '../../utils/php/other/render_left_menu.php';


require '../../private/vars/encryption_vars.php';
require '../../private/vars/user_data_vars.php';

require '../../utils/php/user/check_names_requirements.php';
require '../../utils/php/cookie_management/auth_cookie.php';



// If we have $_POST information it means that the user already tries to change
// a value. Let's check the user input is correct
$is_post = False;    # Is this a POST call? 
$username_errors = array(); # In case this is a POST, we store any errors here
$email_errors = array(); # In case this is a POST, we store any errors here
$pass_errors = array(); # In case this is a POST, we store any errors here
$match_old_pass = True; # In case this is a POST, we store any errors here
// Check first if the old password and any of the other inputs are filled
if(!empty($_POST['old_pass']) && (!empty($_POST['username']) || 
        (!empty($_POST['password']) && !empty($_POST['passverif'])) || 
        !empty($_POST['email']))) {
    
    $is_post = True;
    
    
    // Check if old password matches the current one
    $select_pass_query = mysqli_prepare($GLOBALS['db'],
            "SELECT password FROM users WHERE id=? LIMIT 1");
    mysqli_stmt_bind_param($select_pass_query, "s", $_SESSION['user_id']);
    mysqli_stmt_execute($select_pass_query);
    mysqli_stmt_bind_result($select_pass_query, $hash_pass);
    mysqli_stmt_fetch($select_pass_query);
    mysqli_stmt_close($select_pass_query);


    // Verify stored hash against plain-text password
    if (password_verify($_POST['old_pass'], $hash_pass)) {
        
        # Delete any authentication cookie this user might have in our database.
        delete_server_cookie_by_user_id($_SESSION['user_id']);
        
        if (!empty($_POST['username'])){
            # Check that username fullfills the requirements
            $username_errors = check_family_name_req($_POST['username'], MIN_FAMILY_NAME, LIMIT_FAMILY_NAME, OTHER_CHARS, MY_REGEX, $username_errors);
            if (empty($username_errors)) {
                # Update username
                try {
                    $update_username_query = mysqli_prepare($db,
                        "UPDATE users SET username=? WHERE id = ?");
                    mysqli_stmt_bind_param($update_username_query, "si", $_POST['username'], $_SESSION['user_id']);
                    mysqli_stmt_execute($update_username_query);
                    mysqli_stmt_close($update_username_query);
                } catch (Exception $e){
                    array_push($username_errors, 'No pudimos actualizar el nombre familiar en la base de datos.');
                }
            }
        }
        if (!empty($_POST['email'])){
            # Check email requirements
            $email_errors = check_email_req($_POST['email'], OTHER_CHARS_EMAIL, MY_REGEX, $email_errors);
            if (empty($email_errors)) {
                # Update email
                try{
                    $update_email_query = mysqli_prepare($GLOBALS['db'],
                    "UPDATE users SET email=? WHERE id = ?");
                    mysqli_stmt_bind_param($update_email_query, "si", $_POST['email'], $_SESSION['user_id']);
                    mysqli_stmt_execute($update_email_query);
                    mysqli_stmt_close($update_email_query);
                } catch (Exception $e){
                    array_push($email_errors, 'No pudimos actualizar el email en la base de datos.');
                }
            }
        }
        if (!empty($_POST['password']) && !empty($_POST['passverif'])){
            # Check password requirements
            $pass_errors = check_pass_req($_POST['password'], $_POST['passverif'], MIN_PASSWORD, LIMIT_PASSWORD, OTHER_CHARS_PASS, MY_REGEX, $pass_errors);

            if(empty($pass_errors)){
                # Update password
                $encrypted_password = password_hash($_POST['password'], ENCRYPT_ALGORITHM, ENCRYPT_OPTIONS);  # Does it take too much time? Have a look at example 3 (http://php.net/manual/en/function.password-hash.php)
                try {
                    $update_pass_query = mysqli_prepare($GLOBALS['db'],
                        "UPDATE users SET password=? WHERE id = ?");
                    mysqli_stmt_bind_param($update_pass_query, "si", $encrypted_password, $_SESSION['user_id']);
                    mysqli_stmt_execute($update_pass_query);
                    mysqli_stmt_close($update_pass_query);
                } catch (Exception $e){
                    array_push($pass_errors, 'No pudimos actualizar la contraseña en la base de datos.');
                }
            }                    
        }
    }
    else {  # Old password does not match the one in the db
            $match_old_pass = False;
    }
}

# Get user's info
$get_user_info_query = mysqli_prepare($GLOBALS['db'],
        "SELECT username, email FROM users WHERE id=? LIMIT 1");
mysqli_stmt_bind_param($get_user_info_query, "s", $_SESSION['user_id']);
mysqli_stmt_execute($get_user_info_query);
mysqli_stmt_bind_result($get_user_info_query, $username, $email);
mysqli_stmt_fetch($get_user_info_query);
mysqli_stmt_close($get_user_info_query);


require "tmpl/conf.php";
