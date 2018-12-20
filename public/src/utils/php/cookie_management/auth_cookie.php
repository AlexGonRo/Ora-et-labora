<?php

require_once BASE_PATH_PUBLIC.'src/private/vars/encryption_vars.php';
require_once BASE_PATH_PUBLIC.'src/private/vars/login_vars.php';

function create_validator(){    
    // Correct way to do it according to 
    // https://paragonie.com/blog/2015/04/secure-authentication-php-with-long-term-persistence
    return bin2hex(random_bytes(VALIDATOR_LENGTH));
}

function create_selector(){
    // It's not cryptographically strong but it doesn't have to be. It is just
    // a pointer to the validator.
    return  bin2hex(openssl_random_pseudo_bytes(SELECTOR_LENGTH));
}

function delete_user_cookie(){
    setcookie("selector", "", time() - 3600, COOKIE_BASE_PATH);
    setcookie("validator", "", time() - 3600, COOKIE_BASE_PATH);
}

function delete_server_cookie($selector){
    $delete_auth_query = mysqli_prepare($GLOBALS['db'],
        "DELETE FROM remember_auth "
        . "WHERE selector=?");
    mysqli_stmt_bind_param($delete_auth_query, "s", $selector);
    mysqli_stmt_execute($delete_auth_query);
    mysqli_stmt_close($delete_auth_query);
    
}

function create_user_cookie(){
    $selector = create_selector();
    $validator = create_validator();
    $expiry_date = time()+COOKIE_LIFETIME;
    setcookie("selector", $selector, $expiry_date, COOKIE_BASE_PATH);
    setcookie("validator", $validator, $expiry_date, COOKIE_BASE_PATH);
    return array($selector, $validator, $expiry_date);
}

function create_server_cookie($user_id, $selector, $validator, $expiry_date){
    $insert_auth_query = mysqli_prepare($GLOBALS['db'],
        "INSERT INTO remember_auth(user_id, selector, validator, "
            . "expiry_date) "
            . "VALUES (?,?,?,?)");
    mysqli_stmt_bind_param($insert_auth_query, "isss", $user_id, $selector, 
            hash(VALIDATOR_ENCRYPT_ALGO, $validator), date("Y-m-d H:i:s", $expiry_date));
    mysqli_stmt_execute($insert_auth_query);
    mysqli_stmt_close($insert_auth_query);
}

function update_user_server_validator_cookie($selector){
    $new_validator = create_validator();
                
    $update_val_query = mysqli_prepare($GLOBALS['db'],
        "UPDATE remember_auth "
            . "SET validator=? "
            . "WHERE selector=?");
    mysqli_stmt_bind_param($update_val_query, "ss", hash(VALIDATOR_ENCRYPT_ALGO, $new_validator), $selector);
    mysqli_stmt_execute($update_val_query);
    mysqli_stmt_close($update_val_query);
    $_COOKIE['validator'] = $new_validator;
}