<?php 
session_start(); 
require '../../private/db_connect.php';
require '../../utils/php/other/verify_user.php';
require '../../utils/php/other/render_left_menu.php';
require '../../utils/php/user/select_belongings.php';


if (isset($_GET['username']) && $_GET['username']!=$_SESSION['username']){
    $not_me = true;
} else {
    $not_me = false;
}


# Get user's info
if($not_me){
    $get_user_info_query = mysqli_prepare($GLOBALS['db'],
            "SELECT a.id, a.username, a.role, a.fame, a.kingdom_id, b.name "
            . "FROM users AS a INNER JOIN kingdoms AS b ON a.kingdom_id=b.id "
            . "WHERE a.username=? LIMIT 1");
    mysqli_stmt_bind_param($get_user_info_query, "i", $_GET['username']);
    mysqli_stmt_execute($get_user_info_query);
    mysqli_stmt_bind_result($get_user_info_query, $my_id, $my_username, $my_role,
            $my_fame, $my_kingdom_id, $my_kingdom_name);
    mysqli_stmt_fetch($get_user_info_query);
    mysqli_stmt_close($get_user_info_query);
} else {
    $get_user_info_query = mysqli_prepare($GLOBALS['db'],
            "SELECT a.id, a.username, a.role, a.fame, a.kingdom_id, b.name "
            . "FROM users AS a INNER JOIN kingdoms AS b ON a.kingdom_id=b.id "
            . "WHERE a.id=? LIMIT 1");
    mysqli_stmt_bind_param($get_user_info_query, "i", $_SESSION['user_id']);
    mysqli_stmt_execute($get_user_info_query);
    mysqli_stmt_bind_result($get_user_info_query, $my_id, $my_username, $my_role, 
            $my_fame, $my_kingdom_id, $my_kingdom_name);
    mysqli_stmt_fetch($get_user_info_query);
    mysqli_stmt_close($get_user_info_query);
}

$get_user_info_query = mysqli_prepare($GLOBALS['db'],
    'SELECT a.name, a.location_id, b.name '
        . 'FROM characters AS a INNER JOIN regions AS b ON a.location_id=b.id '
        . 'WHERE belongs_to=? AND death IS NULL');
mysqli_stmt_bind_param($get_user_info_query, "i", $my_id);
mysqli_stmt_execute($get_user_info_query);
mysqli_stmt_bind_result($get_user_info_query, $char_name, $char_location_id, $char_location);
mysqli_stmt_fetch($get_user_info_query);
mysqli_stmt_close($get_user_info_query);

            
$towns = select_towns($my_id);
$resources = select_resources($my_id);
            
            
require "tmpl/profile.php";
