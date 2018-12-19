<?php
session_start(); 
require '../../../../private/db_connect.php';
require '../../../../private/vars/building_vars.php';
require '../../../../utils/php/item_management/add_items.php';
require '../../../../utils/php/item_management/get_lvlup_res.php';

$user_building_id = $_POST['user_building_id'];
$building_id = $_POST['building_id'];
$level = $_POST['level'];
$user_id = $_SESSION['user_id'];

$level_down = $level - 1;


# Check if the building is currently leveling up
$current_lvlup_query = mysqli_prepare($GLOBALS['db'],
    "SELECT * FROM buildings_current_lvlups WHERE user_building_id=?");
mysqli_stmt_bind_param($current_lvlup_query, "i", $user_building_id);
mysqli_stmt_execute($current_lvlup_query);
mysqli_stmt_store_result($current_lvlup_query);
if (mysqli_stmt_num_rows($current_lvlup_query)){
    $under_construction = True;
} else {
    $under_construction = False;
}
mysqli_stmt_close($current_lvlup_query);

# Make sure that we can, indeed, demolish this building
if ($under_construction || (in_array($building_id, CORE_BUILDINGS) && $level <= 1)){
    header('HTTP/1.1 400 Bad Request error');
    return;
}

# Get how many resources we would get back
$rm_lvl_array = get_building_lvlup_resources($building_id, $level_down);
$quantity_items = 0;
foreach ($rm_lvl_array as $key => $value) {
    if ($key != MONEY_ID){
        $quantity_items += round($value*PERC_DEMOLISH);
    }
}


# Get user's warehouse id

$warehouse_id_query = mysqli_prepare($GLOBALS['db'],
    "SELECT id FROM buildings WHERE building_id=".WAREHOUSE_ID." AND owner_id = ?");
mysqli_stmt_bind_param($warehouse_id_query, "i", $user_id);
mysqli_stmt_bind_result($warehouse_id_query, $user_warehouse_id);
mysqli_stmt_execute($warehouse_id_query);
mysqli_stmt_fetch($warehouse_id_query);
mysqli_stmt_close($warehouse_id_query);
        
        
# If the building is full, we cannot level down
# ---------------------------------------------
# Get capacity
$building_cap_query = mysqli_prepare($GLOBALS['db'],
    "SELECT max_capacity FROM buildings_capacity WHERE building_id=? AND level = ?");
mysqli_stmt_bind_param($building_cap_query, "ii", $building_id, $level_down);
mysqli_stmt_bind_result($building_cap_query, $max_capacity);
mysqli_stmt_execute($building_cap_query);
mysqli_stmt_fetch($building_cap_query);
mysqli_stmt_close($building_cap_query);
# How much stuff do we have in the building now?

$building_current_cap_query = mysqli_prepare($GLOBALS['db'],
    "SELECT sum(quantity) FROM warehouses WHERE building_id=?");
mysqli_stmt_bind_param($building_current_cap_query, "i", $user_warehouse_id);
mysqli_stmt_bind_result($building_current_cap_query, $current_capacity);
mysqli_stmt_execute($building_current_cap_query);
mysqli_stmt_fetch($building_current_cap_query);
mysqli_stmt_close($building_current_cap_query);

if ($max_capacity - $current_capacity < 0){
    header('HTTP/1.1 400 Bad Request error');
    return;
} else if ($max_capacity - ($current_capacity+$quantity_items) < 0){
    header('HTTP/1.1 400 Bad Request error');
    return;
}
    


# Give the materials back to the user
foreach ($rm_lvl_array as $item_id => $value) {
    if ($item_id != MONEY_ID){
        add_to_warehouse($user_id, $user_warehouse_id, $item_id, round($value*PERC_DEMOLISH));
    }
}

# Level building down
if ($level>1){
    $lvldown_query = mysqli_prepare($GLOBALS['db'],
        "UPDATE buildings SET level=? WHERE id=?");
    mysqli_stmt_bind_param($lvldown_query, "ii", $level_down, $user_building_id);
    mysqli_stmt_execute($lvldown_query);
    mysqli_stmt_close($lvldown_query);
} else {
    $lvldown_query = mysqli_prepare($GLOBALS['db'],
        "DELETE FROM buildings WHERE id=?");
    mysqli_stmt_bind_param($lvldown_query, "i", $user_building_id);
    mysqli_stmt_execute($lvldown_query);
    mysqli_stmt_close($lvldown_query);
}

return;

