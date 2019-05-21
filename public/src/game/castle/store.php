<?php 
session_start(); 
require '../../private/db_connect.php';
require '../../utils/php/other/verify_user.php';
require '../../utils/php/other/render_left_menu.php';

require "../../private/vars/building_vars.php";

require '../../utils/php/building/compute_space.php';
require '../../utils/php/user/select_belongings.php';
require '../../utils/php/other/ui.php';

# Get pantry and warehouse ids
list($my_ware_id, $my_pantry_id) = get_ware_pantry($_SESSION['user_id']);
          
#######################
# Info about our pantry
#######################

# Get building capacity
list($pantry_occupied, $pantry_max_cap) = compute_pantry_space($db, $_SESSION['user_id']);

$pantry_space_bar_type = get_space_bar_class($pantry_occupied, $pantry_max_cap);

$pantry_items = array();
$pantry_items['Alimentos crudos'] = get_pantry_items_by_class_building(RAW_FOOD_CLASS, $my_pantry_id);
$pantry_items['Alimentos preparados'] = get_pantry_items_by_class_building(PREPARED_FOOD_CLASS, $my_pantry_id);



##########################
# Info about our warehouse
##########################


list($ware_occupied, $ware_max_cap) = compute_warehouse_space($db, $_SESSION['user_id']);

$ware_space_bar_type = get_space_bar_class($ware_occupied, $ware_max_cap);

$ware_items = array();
$ware_items['Misceláneo'] = get_ware_items_by_class_building(MISC_ITEMS_CLASS, $my_ware_id);
$ware_items['Materias primas'] = get_ware_items_by_class_building(RAW_MATERIALS_CLASS, $my_ware_id);
$ware_items['Materiales de construcción'] = get_ware_items_by_class_building(CONSTRUCTION_ITEMS_CLASS, $my_ware_id);
$ware_items['Armas y armaduras'] = get_ware_items_by_class_building(WEAPON_ITEMS_CLASS, $my_ware_id);
$ware_items['Materiales de escritura'] = get_ware_items_by_class_building(PRINTING_ITEMS_CLASS, $my_ware_id);
$ware_items['Artesanía'] = get_ware_items_by_class_building(CRAFTING_ITEMS_CLASS, $my_ware_id);
$ware_items['Trabajo del metal'] = get_ware_items_by_class_building(METALWORK_ITEMS_CLASS, $my_ware_id);
$ware_items['Materiales médicos'] = get_ware_items_by_class_building(MEDICAL_ITEMS_CLASS, $my_ware_id);
$ware_items['Elementos textiles y tíntes'] = get_ware_items_by_class_building(TEXTILE_DYE_ITEMS_CLASS, $my_ware_id);
$ware_items['Herramientas y muebles'] = get_ware_items_by_class_building(FURNITURE_ITEMS_CLASS, $my_ware_id);



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




function get_pantry_items_by_class_building($item_class, $building_id){
    /*
     * Get basic item information using the item class category and a building id
     */
    
    
    # Get items in the pantry
    $pantry_raw_query = mysqli_prepare($GLOBALS['db'],
        "SELECT name, img, quantity "
            . "FROM pantries INNER JOIN item_info ON pantries.item_id = item_info.id "
            . "WHERE building_id=? AND class=? ORDER BY item_id");
    mysqli_stmt_bind_param($pantry_raw_query, "ii", $building_id, $item_class);
    mysqli_stmt_bind_result($pantry_raw_query, $name, $img, $quantity);
    mysqli_stmt_execute($pantry_raw_query);
    mysqli_stmt_store_result($pantry_raw_query);

    $pantry_items = array();
    while (mysqli_stmt_fetch($pantry_raw_query)) {
        $pantry_items[$name] = array(
            'img' => $img,
            'quantity' => $quantity
        );
    }

    mysqli_stmt_close($pantry_raw_query);
    
    return $pantry_items;
}

function get_ware_items_by_class_building($item_class, $building_id){

    $ware_query = mysqli_prepare($GLOBALS['db'],
        "SELECT name, img, quantity "
            . "FROM warehouses INNER JOIN item_info ON warehouses.item_id = item_info.id "
            . "WHERE building_id=? AND class=? ORDER BY item_id");
    mysqli_stmt_bind_param($ware_query, "ii", $building_id, $item_class);
    mysqli_stmt_bind_result($ware_query, $name, $img, $quantity);
    mysqli_stmt_execute($ware_query);
    mysqli_stmt_store_result($ware_query);

    $ware_items = array();
    while (mysqli_stmt_fetch($ware_query)) {
        $ware_items[$name] = array(
            'img' => $img,
            'quantity' => $quantity
        );
    }

    mysqli_stmt_close($ware_query);
    
    return $ware_items;

}