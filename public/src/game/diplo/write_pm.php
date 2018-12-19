<?php 
session_start(); 
require '../../private/db_connect.php';
require '../../utils/php/other/verify_user.php';
require '../../utils/php/other/render_left_menu.php';

require '../../private/vars/msg_vars.php';



# Check whether this is a completely new message or we are replying someone
$is_reply = False;
$msg_sender = "";   # If this is a reply, who sent the message
$msg_title = "";
$msg_body = "";
if(isset($_GET['id'])) {
    $msg_id = intval($_GET['id']);
    //Get all info of that message
    $msg_query = mysqli_prepare($db,
        "SELECT a.title, a.message, b.username, a.user2 "
        . "FROM pm AS a INNER JOIN users AS b ON a.user1 = b.id "
        . "WHERE a.id = ?");
    mysqli_stmt_bind_param($msg_query, "i", $msg_id);
    mysqli_stmt_bind_result($msg_query, $msg_title, $msg_text, $msg_sender, $msg_receiver);
    mysqli_stmt_execute($msg_query);
    mysqli_stmt_store_result($msg_query);
    mysqli_stmt_fetch($msg_query);
    //We check if the message exists and we are allowed to read it
    if(mysqli_stmt_num_rows($msg_query)==1 && $msg_receiver == $_SESSION['user_id']) {
        $is_reply = True;
        $msg_title = REPLY_TITLE_PREP."".htmlentities($msg_title, ENT_QUOTES, 'UTF-8');
        $msg_body = REPLY_SEPARATOR."".htmlentities($msg_text, ENT_QUOTES, 'UTF-8');
    }
}
    
# Let's make a list of all possible addressees

$usernames_query = mysqli_prepare($db,
"SELECT id, username "
    . "FROM users");
mysqli_stmt_bind_result($usernames_query, $my_id, $this_username);
mysqli_stmt_execute($usernames_query);
$list_usernames = array();
while(mysqli_stmt_fetch($usernames_query)) {
    if ($my_id == $_SESSION['user_id'] || $my_id < 10000 ){     // TODO Hardcoded value here to get rid of all the pre-generated users
        continue;
    }
    $list_usernames[] = $this_username;
}
mysqli_stmt_close($usernames_query);
    
    

require 'tmpl/write_pm.php';