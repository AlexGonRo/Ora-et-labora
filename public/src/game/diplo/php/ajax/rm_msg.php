<?php
session_start(); 
require '../../../../private/db_connect.php';
require '../../../../utils/php/other/verify_user.php';

$checked_msgs = $_POST['checked_msgs'];

$checked_qm = implode(',', array_fill(0, count($checked_msgs), '?'));
$checked_types = implode('', array_fill(0, count($checked_msgs), 'i'));

$rm_query = mysqli_prepare($db,
    'DELETE FROM pm WHERE user2 = ? AND id IN ('.$checked_qm.')');
mysqli_stmt_bind_param($rm_query, 'i'.$checked_types, $_SESSION['user_id'], ...$checked_msgs );
mysqli_stmt_execute($rm_query);
mysqli_stmt_close($rm_query);
