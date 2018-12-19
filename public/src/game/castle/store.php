<?php 
session_start(); 
require '../../private/db_connect.php';
require '../../utils/php/other/verify_user.php';
require '../../utils/php/other/render_left_menu.php';

require "../../private/vars/building_vars.php";

require '../../utils/php/building/compute_space.php';



# Get pantry and warehouse ids
$get_ids_query = mysqli_prepare($db,
    "SELECT id, building_id "
        . "FROM buildings "
        . "WHERE owner_id=? AND (building_id=".WAREHOUSE_ID." OR building_id=".PANTRY_ID.")");
mysqli_stmt_bind_param($get_ids_query, "i", $_SESSION['user_id']);
mysqli_stmt_bind_result($get_ids_query, $user_building_id, $building_id);
mysqli_stmt_execute($get_ids_query);

while (mysqli_stmt_fetch($get_ids_query)){
    if ($building_id == PANTRY_ID){
      $my_pantry_id = $user_building_id;
    } else {
        $my_warehouse_id = $user_building_id;
    }
}

mysqli_stmt_close($get_ids_query);            
          

# Info about our pantry

# Get building capacity
list($pantry_occupied, $pantry_max_cap) = compute_pantry_space($db, $_SESSION['user_id']);

$pantry_query = mysqli_prepare($db,
    "SELECT name, quantity "
        . "FROM pantries INNER JOIN item_info ON pantries.item_id = item_info.id "
        . "WHERE building_id=? ORDER BY item_id");
mysqli_stmt_bind_param($pantry_query, "i", $my_pantry_id);
mysqli_stmt_bind_result($pantry_query, $name, $quantity);
mysqli_stmt_execute($pantry_query);
mysqli_stmt_store_result($pantry_query);

$pantry_items = array();
while (mysqli_stmt_fetch($pantry_query)) {
    $pantry_items[$name] = $quantity;
}
             
mysqli_stmt_close($pantry_query);

            
# Info about our warehouse

list($ware_occupied, $ware_max_cap) = compute_warehouse_space($db, $_SESSION['user_id']);

$ware_query = mysqli_prepare($db,
    "SELECT name, quantity "
        . "FROM warehouses INNER JOIN item_info ON warehouses.item_id = item_info.id "
        . "WHERE building_id=? ORDER BY item_id");
mysqli_stmt_bind_param($ware_query, "i", $my_warehouse_id);
mysqli_stmt_bind_result($ware_query, $name, $quantity);
mysqli_stmt_execute($ware_query);
mysqli_stmt_store_result($ware_query);

$ware_items = array();
while (mysqli_stmt_fetch($ware_query)) {
    $ware_items[$name] = $quantity;
}
             
mysqli_stmt_close($ware_query);



# In case we have some GET information
$open_pantry = False;
$open_ware = False;
if(isset($_GET['tab'])) {
    if ($_GET['tab']=='Despensa'){
        $open_pantry = True;
    } else if ($_GET['tab']=='Almacén'){
        $open_ware = True;
    } 
}

require 'tmpl/store.php';