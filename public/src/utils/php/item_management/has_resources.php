<?php

require_once BASE_PATH_PUBLIC.'src/private/vars/building_vars.php';
require_once BASE_PATH_PUBLIC.'src/private/vars/item_vars.php';

function has_resources($user_id, $required_resources){
    
    # Get user's warehouse and pantry id
    $ware_query = mysqli_prepare($GLOBALS['db'],
        "SELECT buildings.id, buildings.building_id "
            . "FROM buildings "
            . "WHERE (building_id=".WAREHOUSE_ID." OR building_id=".PANTRY_ID.") AND owner_id=?");
    mysqli_stmt_bind_param($ware_query, "i", $user_id);
    mysqli_stmt_bind_result($ware_query, $my_building_id, $b_id);
    mysqli_stmt_execute($ware_query);
    while (mysqli_stmt_fetch($ware_query)){
        if ($b_id == WAREHOUSE_ID){
            $my_warehouse_id = $my_building_id;
        } else {
            $my_pantry_id = $my_building_id;
        }
    }
    mysqli_stmt_close($ware_query);
            
    # Check that there are enough resources
    foreach ($required_resources as $item_id => $quantity){
        if ($item_id == MONEY_ID){
            $get_money_query = mysqli_prepare($GLOBALS['db'],
                "SELECT money FROM users WHERE id=?");
            mysqli_stmt_bind_param($get_money_query, "i", $user_id);
            mysqli_stmt_bind_result($get_money_query, $my_money);
            mysqli_stmt_execute($get_money_query);
            mysqli_stmt_fetch($get_money_query);
            mysqli_stmt_close($get_money_query);
            if ($my_money < $quantity){
                            return False;
            }
        }
        else if (in_array($item_id, WAREHOUSE_ITEMS)){
            $get_res_query = mysqli_prepare($GLOBALS['db'],
                "SELECT quantity "
                    . "FROM warehouses "
                    . "WHERE building_id=? AND item_id=?");
            mysqli_stmt_bind_param($get_res_query, "ii", $my_warehouse_id, $item_id);
            mysqli_stmt_bind_result($get_res_query, $my_res);
            mysqli_stmt_execute($get_res_query);
            mysqli_stmt_fetch($get_res_query);
            mysqli_stmt_close($get_res_query);
            if ($my_res< $quantity){
                return False;
            }
        } else {
            $get_res_query = mysqli_prepare($GLOBALS['db'],
                "SELECT quantity "
                    . "FROM pantries "
                    . "WHERE building_id=? AND item_id=?");
            mysqli_stmt_bind_param($get_res_query, "ii", $my_pantry_id, $item_id);
            mysqli_stmt_bind_result($get_res_query, $my_res);
            mysqli_stmt_execute($get_res_query);
            mysqli_stmt_fetch($get_res_query);
            mysqli_stmt_close($get_res_query);
            if ($my_res< $quantity){
                return False;
            }
        }
    }
    
    return True;
}

function compute_number_items_produced($user_id, $recipe){
    
    # Get user's warehouse and pantry id
    $ware_query = mysqli_prepare($GLOBALS['db'],
        "SELECT buildings.id, buildings.building_id "
            . "FROM buildings "
            . "WHERE (building_id=".WAREHOUSE_ID." OR building_id=".PANTRY_ID.") AND owner_id=?");
    mysqli_stmt_bind_param($ware_query, "i", $user_id);
    mysqli_stmt_bind_result($ware_query, $my_building_id, $b_id);
    mysqli_stmt_execute($ware_query);
    while (mysqli_stmt_fetch($ware_query)){
        if ($b_id == WAREHOUSE_ID){
            $my_warehouse_id = $my_building_id;
        } else {
            $my_pantry_id = $my_building_id;
        }
    }
    mysqli_stmt_close($ware_query);
            
    # Check how many resources (related to the recipe) we have
    $my_items = array();
    foreach ($recipe as $item_id => $quantity){
        if (in_array($item_id, WAREHOUSE_ITEMS)){
            $get_res_query = mysqli_prepare($GLOBALS['db'],
                "SELECT quantity "
                    . "FROM warehouses "
                    . "WHERE building_id=? AND item_id=?");
            mysqli_stmt_bind_param($get_res_query, "ii", $my_warehouse_id, $item_id);
            mysqli_stmt_bind_result($get_res_query, $my_res);
            mysqli_stmt_execute($get_res_query);
            mysqli_stmt_fetch($get_res_query);
            mysqli_stmt_close($get_res_query);
            if ($my_res){
                $my_items[$item_id] = $my_res;
            } else {
                $my_items[$item_id] = -1;
            }
        } else {
            $get_res_query = mysqli_prepare($GLOBALS['db'],
                "SELECT quantity "
                    . "FROM pantries "
                    . "WHERE building_id=? AND item_id=?");
            mysqli_stmt_bind_param($get_res_query, "ii", $my_pantry_id, $item_id);
            mysqli_stmt_bind_result($get_res_query, $my_res);
            mysqli_stmt_execute($get_res_query);
            mysqli_stmt_fetch($get_res_query);
            mysqli_stmt_close($get_res_query);
            if ($my_res){
                $my_items[$item_id] = $my_res;
            } else {
                $my_items[$item_id] = -1;
            }
        }
    }
    
    
    # Let's see how many items we can produce by following the recipe
    $total_items = PHP_INT_MAX;  # Final number of items we could produce
    foreach ($recipe as $item_id => $quantity){
        $tmp = $my_items[$item_id] / $quantity;  # Number of items we could produce based on $item_id alone 
        if ($tmp < $total_items){
            $total_items = $tmp;
        }
    }
    
    return max(0, $total_items);
    
}
