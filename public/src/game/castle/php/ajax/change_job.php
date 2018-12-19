<?php
session_start(); 
require '../../../../private/db_connect.php';
require '../../../../utils/php/other/verify_user.php';

$worker_id = $_POST['worker_id'];
$new_job = $_POST['new_job'];

if ($new_job=="--"){
    $new_job = "ninguna";
}

# Before we change anything. Does this worker belong to the user who started the action?
$get_owner_query = mysqli_prepare($db,
    'SELECT owner_id FROM workers WHERE id = ?');
mysqli_stmt_bind_param($get_owner_query, "i", $worker_id);
mysqli_stmt_bind_result($get_owner_query, $owner_id);
mysqli_stmt_execute($get_owner_query);
mysqli_stmt_fetch($get_owner_query);
mysqli_stmt_close($get_owner_query);

if($owner_id != $_SESSION['user_id']){
    return;
}


$my_query = mysqli_prepare($GLOBALS['db'],
    "UPDATE workers SET task=? WHERE id=?");
mysqli_stmt_bind_param($my_query, "si", $new_job, $worker_id);
mysqli_stmt_execute($my_query);
mysqli_stmt_close($my_query);


return True;