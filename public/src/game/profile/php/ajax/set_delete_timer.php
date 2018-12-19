<?php
session_start(); 
require '../../../../private/db_connect.php';
require '../../../../utils/php/other/verify_user.php';
require '../../../../private/vars/cycle_run_vars.php';

$pass = $_POST['pass'];

# Check that the password is correct
$select_pass_query = mysqli_prepare($GLOBALS['db'],
        "SELECT password FROM users WHERE id=? LIMIT 1");
mysqli_stmt_bind_param($select_pass_query, "s", $_SESSION['user_id']);
mysqli_stmt_execute($select_pass_query);
mysqli_stmt_bind_result($select_pass_query, $hash_pass);
mysqli_stmt_fetch($select_pass_query);
mysqli_stmt_close($select_pass_query);
            
            
// Verify stored hash against plain-text password
if (password_verify($pass, $hash_pass)) {

    $update_delete_query = mysqli_prepare($db,
        "UPDATE users SET del_countdown = ".DELETE_COUNTDOWN." WHERE id=?");
    mysqli_stmt_bind_param($update_delete_query, "i", $_SESSION['user_id']);
    mysqli_stmt_execute($update_delete_query);
    mysqli_stmt_close($update_delete_query);

    echo "success";

} else {
        header('HTTP/1.1 400 Bad Request error');
}