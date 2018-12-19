<?php 
session_start(); 
require '../../private/db_connect.php';
require '../../utils/php/other/verify_user.php';
require '../../utils/php/other/render_left_menu.php';


        
//We list all messages in a table
$pm_query = mysqli_prepare($db,
    "SELECT a.id, a.title, b.username, a.timestamp "
        . "FROM sent_pm AS a INNER JOIN users AS b ON a.user2 = b.id "
        . "WHERE a.user1= ? "
        . "ORDER BY a.timestamp DESC ");
            
mysqli_stmt_bind_param($pm_query, "i", $_SESSION['user_id']);
mysqli_stmt_bind_result($pm_query, $msg_id, $title, $receiver_name, $timestamp);
mysqli_stmt_execute($pm_query);
mysqli_stmt_store_result($pm_query);

$messages = array();
while(mysqli_stmt_fetch($pm_query)) {
    $messages[] = array('id' => $msg_id,
        'receiver_name' => $receiver_name,
        'timestamp' => date('d-m-Y H:i:s', strtotime($timestamp)),
        'title' => htmlentities($title, ENT_QUOTES, 'UTF-8'),
       
    );
}
mysqli_stmt_close($pm_query);


require 'tmpl/sent_pm.php';