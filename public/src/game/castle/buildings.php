<?php 
session_start(); 
require '../../private/db_connect.php';
require '../../utils/php/other/verify_user.php';
require '../../utils/php/other/render_left_menu.php';

require "../../private/vars/building_vars.php";

require '../../utils/php/item_management/get_item_info.php';
require '../../utils/php/building/compute_space.php';
require '../../utils/php/item_management/get_lvlup_res.php';
require '../../utils/php/building/get_maint_res.php';
require '../../utils/php/building/can_lvlup.php';


# Space for buildings: 
list($occupied, $total_space) = compute_building_space($db, $_SESSION['user_id']);

# Let's get our buildings (and any required information about them)            
$building_info_query = mysqli_prepare($db,
    'SELECT a.id, a.building_id, b.name, a.preservation, a.level, c.time_left FROM buildings AS a INNER JOIN building_names as b ON a.building_id=b.id '
        . 'LEFT JOIN buildings_current_lvlups AS c ON a.id=c.user_building_id WHERE a.owner_id= ?');
mysqli_stmt_bind_param($building_info_query, "i", $_SESSION['user_id']);
mysqli_stmt_bind_result($building_info_query, $user_building_id, $building_id, $building_name, $preservation, $level, $time_left);
mysqli_stmt_execute($building_info_query);
mysqli_stmt_store_result($building_info_query); # Mandatory to use this buffer, we have SQL sentences inside the loop
            
$total_maintenance = array();   # Total number of resources that we need to keep all our buildings repaired
$buildings = array();
// For each building
while (mysqli_stmt_fetch($building_info_query)) {

    # Check if building is under construction
    if (!is_null($time_left)){
        $under_construction = True;
    } else {
        $under_construction = False;
    }
                
    # Get both names and quantities for the maintenance of the building (and path to the UI icons)
    $maint_array = get_building_maint_res($building_id, $level);
    if(empty($maint_array)){    //TODO This 'if' would not be necessary if the DB had entries for all buildings at all levels.
        $maint_names = array();
        $maint_icons = array();
    } else {
        $maint_names = get_item_names(array_keys($maint_array));
        $maint_icons = get_item_icons(array_keys($maint_array));
    }
    
    # Add the maintenance of this building to the global resource count
    foreach (array_keys($maint_array) as $i) {
        $item_name = $maint_names[$i];
        $item_quantity = $maint_array[$i];
        $item_icon = $maint_icons[$i];
        
        if (array_key_exists($item_name, $total_maintenance)){
            $total_maintenance[$item_name]['quantity'] += $item_quantity;
        }
        else{
            $total_maintenance[$item_name] = array(
                'icon' => $item_icon,
                'quantity' => $item_quantity);
        }
        
        
    } 


                
    # Get both names and quantities for leveling up the building
    $lvlup_array = get_building_lvlup_resources($building_id, $level);
    if(empty($lvlup_array)){    # We got the building to the highest level
        $lvlup_names = array();
        $lvlup_icons = array();
    } else {
        $lvlup_names = get_item_names(array_keys($lvlup_array));
        $lvlup_icons = get_item_icons(array_keys($lvlup_array));
    }
    
                
    # Can we level up this building?
    $can_lvlup = can_lvlup($total_space - $occupied, $_SESSION['user_id'], $lvlup_array, $building_id);
    
    # Can we demolish this building (or decrease its level by 1)
    $can_lvldown = !$under_construction && $level >= 1 && (in_array($building_id, CORE_BUILDINGS) && $level > 1);
    # If we can demolish this building, how many resources would the user receive back?           
    $lvldown_str = "";
    if ($can_lvldown) {
        $rm_lvl_array = get_building_lvlup_resources($building_id, $level-1);
        $names = get_item_names(array_keys($lvlup_array));
        foreach ($rm_lvl_array as $key => $value) {
            if ($key != MONEY_ID){
                $lvldown_str = $lvldown_str.$names[$key].": ".($value* PERC_DEMOLISH).", " ;
            }
        }
        $lvldown_str = substr($lvldown_str, 0, -2);

    }
    
    # Let us prepare the direct access to the building
    $direct_access = "";
    if ($building_name == 'Despensa' || $building_name == 'Almacén'){ 
        $direct_access = "store.php?tab=".urlencode($building_name);
    } elseif ($building_name == 'Cocina'){
        $direct_access = "produce.php?tab=".urlencode($building_name);
    }
    
    
    
    // Let's re-arrange all the information related to maintenance and lvlup resources
    
    $my_maint_array = array();
    foreach($maint_array as $item_id => $item_quantity){
        $item_name = $maint_names[$item_id];
        $item_icon = $maint_icons[$item_id];
        $my_maint_array[$item_name] = array(
            'icon' => $item_icon,
            'quantity' => $item_quantity
        );
    }
            
    $my_lvlup_array = array();
    foreach($maint_array as $item_id => $item_quantity){
        $item_name = $lvlup_names[$item_id];
        $item_icon = $lvlup_icons[$item_id];
        $my_lvlup_array[$item_name] = array(
            'icon' => $item_icon,
            'quantity' => $item_quantity
        );
    }

    $buildings[] = array('id' => $user_building_id,
        'type' => $building_id,
        'name' => $building_name,
        'preservation' => $preservation,
        'level' => $level,
        'under_construction' => $under_construction,
        'maint_array' => $my_maint_array,
        'lvlup_array' => $my_lvlup_array,
        'can_lvlup' => $can_lvlup,
        'can_lvldown' => $can_lvldown,
        'lvldown_str' => $lvldown_str,
        'direct_access' => $direct_access
        );
}
            
mysqli_stmt_close($building_info_query);

require 'tmpl/buildings.php';