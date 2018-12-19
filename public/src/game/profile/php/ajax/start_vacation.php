<?php
session_start(); 
require '../../../../private/db_connect.php';
require '../../../../utils/php/other/verify_user.php';

$pass = $_POST['pass'];


// Check if old password matches the current one
$select_pass_query = mysqli_prepare($GLOBALS['db'],
        "SELECT password FROM users WHERE id=? LIMIT 1");
mysqli_stmt_bind_param($select_pass_query, "s", $_SESSION['user_id']);
mysqli_stmt_execute($select_pass_query);
mysqli_stmt_bind_result($select_pass_query, $hash_pass);
mysqli_stmt_fetch($select_pass_query);
mysqli_stmt_close($select_pass_query);

// Verify stored hash against plain-text password
if (password_verify($pass, $hash_pass)) {
    $my_date = date('Y-m-d H:i:s');
    $update_delete_query = mysqli_prepare($GLOBALS['db'],
        "UPDATE users SET on_vacation = 1, start_vacation=? WHERE id=?");
    mysqli_stmt_bind_param($update_delete_query, "si", $my_date, $_SESSION['user_id']);
    mysqli_stmt_execute($update_delete_query);
    mysqli_stmt_close($update_delete_query);

    echo "success";

} else {
        #throw new Exception('La contraseña introducida no es correcta.');
        header('HTTP/1.1 400 Bad Request error');
}