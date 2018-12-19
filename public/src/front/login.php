<?php
require '../private/db_connect.php';
include 'php/login_methods.php';

$errors = array();
ob_start();
$want_login = False;

# If user tried to log in using a "Remember me" cookie
if (isset($_COOKIE["selector"]) && isset($_COOKIE["validator"])) {
    $want_login = True;
    $errors = login_with_cookie($errors);
    if(empty($errors)){
        $selector_query = mysqli_prepare($GLOBALS['db'],
        "SELECT user_id, b.username "
            . "FROM remember_auth AS a INNER JOIN users as b ON a.user_id=b.id "
            . "WHERE selector=?");
        mysqli_stmt_bind_param($selector_query, "s", $_COOKIE["selector"]);
        mysqli_stmt_execute($selector_query);
        mysqli_stmt_bind_result($selector_query, $user_id, $username);
        mysqli_stmt_fetch($selector_query);
        mysqli_stmt_close($selector_query);
    }
}

# If user tried to log in by submitting a POST request
if (isset($_POST['username']) && isset($_POST['pass'])) {
    $want_login = True;
    $errors = login_with_credentials($errors);
    if(empty($errors)){
        $username = $_POST['username'];
        $select_id_query = mysqli_prepare($GLOBALS['db'],
                "SELECT id FROM users WHERE username=?");
        mysqli_stmt_bind_param($select_id_query, "s", $username);
        mysqli_stmt_execute($select_id_query);
        mysqli_stmt_bind_result($select_id_query, $user_id);
        mysqli_stmt_fetch($select_id_query);
        mysqli_stmt_close($select_id_query);
    }
}

if($want_login && empty($errors)){
    log_user_in($user_id, $username);
    ob_end_flush();
    exit();
}

$login_errors = implode("<br>", $errors);  // Pass errors to string format
ob_end_flush();

require 'tmpl/login.php';

