<?php 
session_start(); 
require '../../private/db_connect.php';
require '../../utils/php/other/verify_user.php';
require '../../utils/php/other/render_left_menu.php';

//We check if the ID of the message is defined
$my_error = False; # Flag in case there was an error when loading the message
if(isset($_GET['id'])) {
    $msg_id = intval($_GET['id']);
    //Get all info of that message
    if (isset($_GET['sent']) && $_GET['sent'] == 'True'){
        $query_text = "SELECT a.title, a.message, b.username, a.user1, a.user2 "
        . "FROM sent_pm AS a INNER JOIN users AS b ON a.user1 = b.id "
        . "WHERE a.id = ?";
    }
    else {
        $query_text = "SELECT a.title, a.message, b.username, a.user1, a.user2 "
        . "FROM pm AS a INNER JOIN users AS b ON a.user1 = b.id "
        . "WHERE a.id = ?";
    }
    $msg_query = mysqli_prepare($db,
        $query_text);
    mysqli_stmt_bind_param($msg_query, "i", $msg_id);
    mysqli_stmt_bind_result($msg_query, $msg_title, $msg_text, $msg_sender_name,
            $msg_sender_id, $msg_receiver);
    mysqli_stmt_execute($msg_query);
    mysqli_stmt_store_result($msg_query);
    mysqli_stmt_fetch($msg_query);

    //We check if the message exists and we are allowed to read it
    if(mysqli_stmt_num_rows($msg_query)==1 && ($msg_receiver == $_SESSION['user_id'] || $msg_sender_id == $_SESSION['user_id'])) {
        // The discussion will be placed in read messages
        $to_read_query = mysqli_prepare($db,
            "UPDATE pm "
            . "SET is_read = 1 "
            . "WHERE id = ?");
        mysqli_stmt_bind_param($to_read_query, "i", $msg_id);
        mysqli_stmt_execute($to_read_query);
        mysqli_stmt_close($to_read_query);

        // Change title and text in case they have "weird" characters

        $msg_title = htmlentities($msg_title, ENT_QUOTES, 'UTF-8');
        $msg_text = nl2br(htmlentities($msg_text, ENT_QUOTES, 'UTF-8'));
        
    } else {
        # There is no message with that ID or we are not allowed to read it
        $my_error = True;
    }
    
    mysqli_stmt_close($msg_query);

} else {
    # We didn't get any GET information and, thus, we don't know which message to read
    $my_error = True;
    
}

require 'tmpl/read_pm.php';