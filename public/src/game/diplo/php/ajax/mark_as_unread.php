<?php
session_start(); 
require '../../../../private/db_connect.php';
require '../../../../utils/php/other/verify_user.php';

$checked_msgs = $_POST['checked_msgs'];

$checked_qm = implode(',', array_fill(0, count($checked_msgs), '?'));
$checked_types = implode('', array_fill(0, count($checked_msgs), 'i'));

$mark_unread_query = mysqli_prepare($db,
    'UPDATE pm SET is_read = 0 WHERE user2 = ? AND id IN ('.$checked_qm.')');
mysqli_stmt_bind_param($mark_unread_query, 'i'.$checked_types, $_SESSION['user_id'], ...$checked_msgs  );
mysqli_stmt_execute($mark_unread_query);
mysqli_stmt_close($mark_unread_query);