<?php 
session_start(); 
require '../../private/db_connect.php';
require '../../utils/php/other/verify_user.php';
require '../../utils/php/other/render_left_menu.php';

require 'php/get_news_alerts.php';

require '../../private/vars/moving_to_peninsula_vars.php';

# Get all the info we might need from the user
$user_info_query = mysqli_prepare($db,
    'SELECT kingdom_id, reg_time, tut_phase, del_countdown, on_vacation FROM users WHERE id=? LIMIT 1');
mysqli_stmt_bind_param($user_info_query, "i", $_SESSION['user_id']);
mysqli_stmt_bind_result($user_info_query, $my_kingdom_id, $reg_time, $tut_phase, $del_countdown, $on_vacation);
mysqli_stmt_execute($user_info_query);
mysqli_stmt_fetch($user_info_query);
mysqli_stmt_close($user_info_query);


# Would we need a welcome message?
$welcome = False;
if (isset($_GET["login"]) && $_GET["login"]){
    $welcome = True;
}

    
# Do we need to cancel the countdown for deleting this user?
if (!is_null($del_countdown)){
    $cancel_delete_query = mysqli_prepare($db,
        "UPDATE users SET del_countdown = NULL WHERE id=?");
    mysqli_stmt_bind_param($cancel_delete_query, "i", $_SESSION['user_id']);
    mysqli_stmt_execute($cancel_delete_query);
    mysqli_stmt_close($cancel_delete_query);
}
    
# Coming back from vacation?
if ($on_vacation){
    $my_date = date('Y-m-d H:i:s');
    $cancel_vacation_query = mysqli_prepare($db,
        "UPDATE users SET on_vacation = 0, start_vacation = NULL, last_vacation = ? WHERE id=?");
    mysqli_stmt_bind_param($cancel_vacation_query, "si", $my_date, $_SESSION['user_id']);
    mysqli_stmt_execute($cancel_vacation_query);
    mysqli_stmt_close($cancel_vacation_query);
}

    
# Check if a tutorial is necessary
$need_tutorial = False;
if ($tut_phase==0){
    $need_tutorial = True;
}

# Check if we are still in France
$still_in_France = False;
$days_left = 999;
if ($my_kingdom_id == INIT_KINGDOM_ID) {
    $still_in_France = True;
    # Get number of dates since registration
    $current_date = date_create(date("Y-m-d H:i:s"));
    $reg_time = date_create($reg_time);
    $interval = date_diff($current_date, $reg_time);
    $days = $interval->format('%a');
    # How many days do we have until we are forced to leave France?
    $days_left = MAX_DAYS_IN_HEAVEN - $days;
}

$news = get_news($_SESSION, $db);
$alerts = get_alerts($_SESSION, $db);
$active_actions = get_active_actions($_SESSION, $db);
        

require "tmpl/index.php";
