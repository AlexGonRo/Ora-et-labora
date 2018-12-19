<?php
session_start(); 
require '../../../../private/db_connect.php';
require '../../../../private/vars/building_vars.php';

require_once '../../../../utils/php/other/verify_user.php';
require_once '../../../../utils/php/item_management/has_resources.php';
require_once '../../../../utils/php/item_management/consume_items.php';

require_once '../../../../utils/php/item_management/get_lvlup_res.php';
require_once '../../../../utils/php/building/compute_space.php';
require_once '../../../../utils/php/building/can_lvlup.php';


$user_building_id = $_POST['user_building_id'];
$building_id = $_POST['building_id'];
$level = $_POST['level'];
$user_id = $_SESSION['user_id'];

# Check that the user still has building space for the new building
list($occupied, $total_space) = compute_building_space($GLOBALS['db'], $user_id);
$free_space = $total_space - $occupied;

# Make a list of all the resources we need
$required_resources = get_building_lvlup_resources($building_id, $level);

# Let's make sure (again) the user has the resources
$flag = can_lvlup($free_space, $user_id, $required_resources, $user_building_id);
if (!$flag) {
    return ;
}
# Consume those resources

consume_items($user_id, $required_resources);


# Update the building information
$get_lvlup_time_query = mysqli_prepare($GLOBALS['db'],
    "SELECT lvlup_time FROM buildings_lvlup_time WHERE building_id=? AND level=?");
mysqli_stmt_bind_param($get_lvlup_time_query, "ii", $building_id, $level);
mysqli_stmt_bind_result($get_lvlup_time_query, $my_time);
mysqli_stmt_execute($get_lvlup_time_query);
mysqli_stmt_fetch($get_lvlup_time_query);
mysqli_stmt_close($get_lvlup_time_query);
            
            
$insert_lvlup_query = mysqli_prepare($GLOBALS['db'],
    "INSERT INTO buildings_current_lvlups(user_building_id, time_left) VALUES (?, ?)");
mysqli_stmt_bind_param($insert_lvlup_query, "ii", $user_building_id, $my_time);
mysqli_stmt_execute($insert_lvlup_query);
mysqli_stmt_close($insert_lvlup_query);


return True;
    
