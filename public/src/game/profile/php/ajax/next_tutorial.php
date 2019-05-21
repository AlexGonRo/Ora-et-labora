<?php
session_start();
require '../../../../private/db_connect.php';
require '../../../../utils/php/other/verify_user.php';

$user_id = $_SESSION['user_id'];

# Check that the user can really take this action
$get_info_query = mysqli_prepare($GLOBALS['db'],
    'SELECT tut_phase '
        . 'FROM users '
        . 'WHERE id=?');
mysqli_stmt_bind_param($get_info_query, "i", $user_id);
mysqli_stmt_bind_result($get_info_query, $tut_phase);
mysqli_stmt_execute($get_info_query);
mysqli_stmt_fetch($get_info_query);
mysqli_stmt_close($get_info_query);

# Update
if($tut_phase==0){
    $next_p = "-1";   # Next phase number
    $update_query = mysqli_prepare($GLOBALS['db'],
        'UPDATE users '
            . 'SET tut_phase=? '
            . 'WHERE id=?');
    mysqli_stmt_bind_param($update_query, "si", $next_p, $user_id);
    mysqli_stmt_execute($update_query);
    mysqli_stmt_close($update_query);
}

echo "Done";