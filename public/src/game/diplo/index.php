<?php 
session_start(); 
require '../../private/db_connect.php';
require '../../utils/php/other/verify_user.php';
require '../../utils/php/other/render_left_menu.php';

$sent_message = False;  # Flag in case we just sent a message to a user
$msg_error = False;
if (isset($_POST['msg_beneficiary'])) {    // If we just sent a message or a treaty offer
    $sent_message = True;
    $receiver_name = $_POST['msg_beneficiary'] ;
    $sender_id = $_SESSION['user_id'] ;
    $msg_title = $_POST['msg_title'] ;
    $msg_body = $_POST['msg_body'] ;

    # Check that the user we are sending the message to exists
    $username_query = mysqli_prepare($db,
        "SELECT id "
            . "FROM users "
            . "WHERE username= ?");
    mysqli_stmt_bind_param($username_query, "i", $receiver_name);
    mysqli_stmt_bind_result($username_query, $receiver_id);
    mysqli_stmt_execute($username_query);
    mysqli_stmt_store_result($username_query);
    if (mysqli_stmt_fetch($username_query)){
        # Insert into DB
        $pm_query = mysqli_prepare($db,
            "INSERT INTO pm(title, user1, user2, message, timestamp) "
                . "VALUES (?, ?, ?, ?, now())");
        mysqli_stmt_bind_param($pm_query, "siis", $msg_title, $sender_id, $receiver_id, $msg_body);
        mysqli_stmt_execute($pm_query);
        mysqli_stmt_close($pm_query);

        $sent_pm_query = mysqli_prepare($db,
            "INSERT INTO sent_pm(title, user1, user2, message, timestamp) "
                . "VALUES (?, ?, ?, ?, now())");
        mysqli_stmt_bind_param($sent_pm_query, "siis", $msg_title, $sender_id, $receiver_id, $msg_body);
        mysqli_stmt_execute($sent_pm_query);
        mysqli_stmt_close($sent_pm_query);

    } else {
        # We could not find the user on the DB
        $msg_error = True;
    }
    mysqli_stmt_close($username_query);


}

    


//We list his messages in a table
$pm_query = mysqli_prepare($db,
    "SELECT a.id, a.title, b.username, a.timestamp, a.is_read "
        . "FROM pm AS a INNER JOIN users AS b ON a.user1 = b.id "
        . "WHERE user2= ? "
        . "ORDER BY a.timestamp DESC ");
            
mysqli_stmt_bind_param($pm_query, "i", $_SESSION['user_id']);
mysqli_stmt_bind_result($pm_query, $msg_id, $title, $sender_name, $timestamp, $is_read);
mysqli_stmt_execute($pm_query);

$messages = array();
while(mysqli_stmt_fetch($pm_query)) {

    $messages[] = array( 'id' => $msg_id,
        'sender_name' => $sender_name,
        'timestamp' => date('d-m-Y H:i:s', strtotime($timestamp)),
        'title' => htmlentities($title, ENT_QUOTES, 'UTF-8'),
        'is_read' => $is_read
    );

}
mysqli_stmt_close($pm_query);
    
require 'tmpl/index.php';