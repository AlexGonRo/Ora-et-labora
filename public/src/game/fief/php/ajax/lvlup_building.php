<?php
session_start(); 
require '../../../../private/db_connect.php';
require '../../../../utils/php/other/verify_user.php';

require '../../../../private/vars/item_vars.php';
require '../../../../private/vars/building_vars.php';

require '../../../../utils/php/item_management/has_resources.php';
require '../../../../utils/php/item_management/get_lvlup_res.php';
require '../../../../utils/php/item_management/consume_items.php';
require '../../../../utils/php/item_management/get_item_names.php';




$town_id = $_POST['town_id'];
$town_building_id = $_POST['town_building_id'];
$user_id = $_SESSION['user_id'];

# Check that the town belongs to the user
$ownership_query = mysqli_prepare($db,
    'SELECT owner_id FROM towns WHERE id = ?');
mysqli_stmt_bind_param($ownership_query, "i", $town_id);
mysqli_stmt_bind_result($ownership_query, $town_owner_id);
mysqli_stmt_execute($ownership_query);
mysqli_stmt_fetch($ownership_query);
mysqli_stmt_close($ownership_query);

if ($town_owner_id != $user_id){
    return;
}

#Get current lvl of the building
$town_building_query = mysqli_prepare($db,
    'SELECT level, town_building_id FROM town_buildings WHERE id=?');
mysqli_stmt_bind_param($town_building_query, "i", $town_building_id);
mysqli_stmt_bind_result($town_building_query, $level, $main_building_id);
mysqli_stmt_execute($town_building_query);
mysqli_stmt_fetch($town_building_query);
mysqli_stmt_close($town_building_query);
        
# Make a list of all the resources we need
$lvlup_array = get_town_building_lvlup_resources($main_building_id, $level);


# Check again that we can update the building
$flag = has_resources($user_id, $lvlup_array);
if (!$flag) {
    return ;
}

# Consume the resources

consume_items($user_id, $lvlup_array);

#Lvl up!
$get_lvlup_time_query = mysqli_prepare($GLOBALS['db'],
    "SELECT lvlup_time FROM town_buildings_lvlup_time WHERE building_id=? AND level=?");
mysqli_stmt_bind_param($get_lvlup_time_query, "ii", $main_building_id, $level);
mysqli_stmt_bind_result($get_lvlup_time_query, $my_time);
mysqli_stmt_execute($get_lvlup_time_query);
mysqli_stmt_fetch($get_lvlup_time_query);
mysqli_stmt_close($get_lvlup_time_query);
            
            
$insert_lvlup_query = mysqli_prepare($GLOBALS['db'],
    "INSERT INTO town_buildings_current_lvlups(town_building_id, time_left) VALUES (?, ?)");
mysqli_stmt_bind_param($insert_lvlup_query, "ii", $town_building_id, $my_time);
mysqli_stmt_execute($insert_lvlup_query);
mysqli_stmt_close($insert_lvlup_query);



echo "Success!";
