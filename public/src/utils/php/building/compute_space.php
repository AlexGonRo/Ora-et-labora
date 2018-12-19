<?php

require_once BASE_PATH_PUBLIC.'src/private/vars/building_vars.php';

function compute_building_space($db, $user_id){

$building_info_query = mysqli_prepare($db,
        'SELECT building_id, level FROM buildings WHERE owner_id= ?');
mysqli_stmt_bind_param($building_info_query, "i", $user_id);
mysqli_stmt_bind_result($building_info_query, $user_building_id, $level);
mysqli_stmt_execute($building_info_query);


$occupied = 0;  # Occupied space
while (mysqli_stmt_fetch($building_info_query)) {
    if (!in_array($user_building_id, MAIN_BUILDING_IDS)){
        $occupied += EXISTENCE_BUILDING_SPACE; # Just having the building consumes space 
        $occupied += $level;
    } else {
        $total_space = MAIN_BUILDING_SPACE[$level-1];
    }
}
mysqli_stmt_close($building_info_query);

return array($occupied, $total_space);

}

function compute_workers_space($db, $user_id){

# Get number of workers
    $worker_count_query = mysqli_prepare($db,
        'SELECT * FROM workers WHERE owner_id= ?');
    mysqli_stmt_bind_param($worker_count_query, "i", $user_id);
    mysqli_stmt_execute($worker_count_query);
    mysqli_stmt_store_result($worker_count_query);
    $num_workers = mysqli_stmt_num_rows($worker_count_query);
    $a = mysqli_stmt_error_list($worker_count_query);
    mysqli_stmt_close($worker_count_query);
    
# Get user's dormitory level
    $dorm_lvl_query = mysqli_prepare($db,
        'SELECT level FROM buildings WHERE owner_id= ? AND building_id = '.DORMITORY_ID);
    mysqli_stmt_bind_param($dorm_lvl_query, "i", $user_id);
    mysqli_stmt_bind_result($dorm_lvl_query, $lvl);
    mysqli_stmt_execute($dorm_lvl_query);
    mysqli_stmt_fetch($dorm_lvl_query);
    mysqli_stmt_close($dorm_lvl_query);

# Get maximum number of workers allowed
    $dorm_cap_query = mysqli_prepare($db,
        'SELECT max_capacity FROM buildings_capacity WHERE building_id = '.DORMITORY_ID.' AND level = ?');
    mysqli_stmt_bind_param($dorm_cap_query, "i", $lvl);
    mysqli_stmt_bind_result($dorm_cap_query, $max_cap);
    mysqli_stmt_execute($dorm_cap_query);
    mysqli_stmt_fetch($dorm_cap_query);
    mysqli_stmt_close($dorm_cap_query);
    
    
return array($num_workers, $max_cap);

}

function compute_warehouse_space($db, $user_id){
    # Get building id and level
    $ware_info_query = mysqli_prepare($db,
        'SELECT id, level FROM buildings WHERE owner_id= ? AND building_id = '.WAREHOUSE_ID);
    mysqli_stmt_bind_param($ware_info_query, "i", $user_id);
    mysqli_stmt_bind_result($ware_info_query, $my_ware_id, $ware_lvl);
    mysqli_stmt_execute($ware_info_query);
    mysqli_stmt_fetch($ware_info_query);
    mysqli_stmt_close($ware_info_query);
    
    # Get space occupied
    $ware_items_query = mysqli_prepare($db,
        'SELECT SUM(quantity) FROM warehouses WHERE building_id = ?');
    mysqli_stmt_bind_param($ware_items_query, "i", $my_ware_id);
    mysqli_stmt_bind_result($ware_items_query, $occupied);
    mysqli_stmt_execute($ware_items_query);
    mysqli_stmt_fetch($ware_items_query);
    mysqli_stmt_close($ware_items_query);
    
    # Get maximum capacity
    $ware_cap_query = mysqli_prepare($db,
        'SELECT max_capacity FROM buildings_capacity WHERE building_id = '.WAREHOUSE_ID.' AND level = ?');
    mysqli_stmt_bind_param($ware_cap_query, "i", $ware_lvl);
    mysqli_stmt_bind_result($ware_cap_query, $max_cap);
    mysqli_stmt_execute($ware_cap_query);
    mysqli_stmt_fetch($ware_cap_query);
    mysqli_stmt_close($ware_cap_query);
    
    return array((int)$occupied, $max_cap);
}

function compute_pantry_space($db, $user_id){
    # Get building id and level
    $pantry_info_query = mysqli_prepare($db,
        'SELECT id, level FROM buildings WHERE owner_id= ? AND building_id = '.PANTRY_ID);
    mysqli_stmt_bind_param($pantry_info_query, "i", $user_id);
    mysqli_stmt_bind_result($pantry_info_query, $my_pantry_id, $pantry_lvl);
    mysqli_stmt_execute($pantry_info_query);
    mysqli_stmt_fetch($pantry_info_query);
    mysqli_stmt_close($pantry_info_query);
    
    # Get space occupied
    $pantry_items_query = mysqli_prepare($db,
        'SELECT SUM(quantity) FROM pantries WHERE building_id = ?');
    mysqli_stmt_bind_param($pantry_items_query, "i", $my_pantry_id);
    mysqli_stmt_bind_result($pantry_items_query, $occupied);
    mysqli_stmt_execute($pantry_items_query);
    mysqli_stmt_fetch($pantry_items_query);
    mysqli_stmt_close($pantry_items_query);
    
    # Get maximum capacity
    $pantry_cap_query = mysqli_prepare($db,
        'SELECT max_capacity FROM buildings_capacity WHERE building_id = '.PANTRY_ID.' AND level = ?');
    mysqli_stmt_bind_param($pantry_cap_query, "i", $pantry_lvl);
    mysqli_stmt_bind_result($pantry_cap_query, $max_cap);
    mysqli_stmt_execute($pantry_cap_query);
    mysqli_stmt_fetch($pantry_cap_query);
    mysqli_stmt_close($pantry_cap_query);
    
    return array((int)$occupied, $max_cap);
}