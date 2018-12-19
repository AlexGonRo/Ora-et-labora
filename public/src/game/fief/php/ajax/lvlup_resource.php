<?php
session_start(); 
require '../../../../private/db_connect.php';
require '../../../../utils/php/other/verify_user.php';

require '../../../../utils/php/item_management/has_resources.php';
require '../../../../utils/php/item_management/get_lvlup_res.php';
require '../../../../utils/php/item_management/consume_items.php';
require '../../../../utils/php/item_management/get_item_names.php';

require '../../../../private/vars/building_vars.php';
require '../../../../private/vars/item_vars.php';


$resource_id = $_POST['resource_id'];
$user_id = $_SESSION['user_id'];

# Check that the resource belongs to the user!
$ownership_query = mysqli_prepare($db,
    'SELECT owner_id FROM land_resources WHERE id = ?');
mysqli_stmt_bind_param($ownership_query, "i", $resource_id);
mysqli_stmt_bind_result($ownership_query, $res_owner_id);
mysqli_stmt_execute($ownership_query);
mysqli_stmt_fetch($ownership_query);
mysqli_stmt_close($ownership_query);
if ($res_owner_id != $user_id){
    return;
}

# Check that the building is not already under construction
$already_const_query = mysqli_prepare($db,
    'SELECT * FROM land_resources_current_lvlups WHERE land_resource_id = ? LIMIT 1');
mysqli_stmt_bind_param($already_const_query, "i", $resource_id);
mysqli_stmt_execute($already_const_query);
mysqli_stmt_store_result($already_const_query);
$flag = mysqli_stmt_num_rows($already_const_query);
mysqli_stmt_close($already_const_query);
if ($flag == 1){
    return;
}

#Get current lvl of the building
$res_query = mysqli_prepare($db,
    'SELECT level, resource FROM land_resources WHERE id=?');
mysqli_stmt_bind_param($res_query, "i", $resource_id);
mysqli_stmt_bind_result($res_query, $level, $main_resource_id);
mysqli_stmt_execute($res_query);
mysqli_stmt_fetch($res_query);
mysqli_stmt_close($res_query);

        
# Make a list of all the resources we need
$required_resources = get_res_lvlup_resources($main_resource_id, $level);

# Check again that we can update the building
$flag = has_resources($user_id, $required_resources);
if (!$flag) {
    return ;
}

# Consume the resources

consume_items($user_id, $required_resources);

#Lvl up!

$get_lvlup_time_query = mysqli_prepare($GLOBALS['db'],
    "SELECT lvlup_time FROM land_resources_lvlup_time WHERE resource_id=? AND level=?");
mysqli_stmt_bind_param($get_lvlup_time_query, "ii", $main_resource_id, $level);
mysqli_stmt_bind_result($get_lvlup_time_query, $my_time);
mysqli_stmt_execute($get_lvlup_time_query);
mysqli_stmt_fetch($get_lvlup_time_query);
mysqli_stmt_close($get_lvlup_time_query);
            
            
$insert_lvlup_query = mysqli_prepare($GLOBALS['db'],
    "INSERT INTO land_resources_current_lvlups(land_resource_id, time_left) VALUES (?, ?)");
mysqli_stmt_bind_param($insert_lvlup_query, "ii", $resource_id, $my_time);
mysqli_stmt_execute($insert_lvlup_query);
mysqli_stmt_close($insert_lvlup_query);



echo "Success!";

