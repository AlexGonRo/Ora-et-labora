<?php

require_once BASE_PATH_PUBLIC.'src/private/vars/building_vars.php';
require_once BASE_PATH_PUBLIC.'src/utils/php/building/compute_space.php';


function add_to_warehouse($user_id, $my_warehouse_id, $item_id, $quantity){
    
    list($occupied, $max_capacity) = compute_warehouse_space($GLOBALS['db'], $user_id);
    
    $free_space = $max_capacity - $occupied;
    
    if ($free_space < $quantity ) {# If it can only store part of $quantity (or nothing at all)...
        $quantity = $quantity - ($quantity - $free_space);  // TODO we should probably send an alert message to the user to say the warehouse if full
        if ($quantity <= 0){
            return;
        } 
    }
    
    # Insert item in warheouse
    $in_warehouse_query = mysqli_prepare($GLOBALS['db'],
        "SELECT * FROM warehouses WHERE building_id=? AND item_id=?");
    mysqli_stmt_bind_param($in_warehouse_query, "ii", $my_warehouse_id, $item_id);
    mysqli_stmt_execute($in_warehouse_query);
    mysqli_stmt_store_result($in_warehouse_query);
    if (mysqli_stmt_num_rows($in_warehouse_query)){
        $add_query = mysqli_prepare($GLOBALS['db'],
            "UPDATE warehouses SET quantity=quantity + ? WHERE building_id=? AND item_id=?");
        mysqli_stmt_bind_param($add_query, "iii", $quantity, $my_warehouse_id, $item_id);
        mysqli_stmt_execute($add_query);
        mysqli_stmt_close($add_query);
    } else {
        $add_query = mysqli_prepare($GLOBALS['db'],
            "INSERT INTO warehouses(building_id, item_id, quantity) VALUES (?,?,?)");
        mysqli_stmt_bind_param($add_query, "iii", $my_warehouse_id, $item_id, $quantity);
        mysqli_stmt_execute($add_query);
        mysqli_stmt_close($add_query);
    }

    mysqli_stmt_close($in_warehouse_query);
    
}

function add_to_pantry($user_id, $my_pantry_id, $item_id, $quantity){
        
    list($occupied, $max_capacity) = compute_pantry_space($GLOBALS['db'], $user_id);
    
    $free_space = $max_capacity - $occupied;
    
    if ($free_space < $quantity) {# If it can only store part of $quantity (or nothing at all)...
        $quantity = $quantity - ($quantity - $free_space);  // TODO we should probably send an alert message to the user to say the warehouse if full
        if ($quantity <= 0){
            return;
        }   
    }
    
    # Insert item in pantry
    $in_pantry_query = mysqli_prepare($GLOBALS['db'],
        "SELECT * FROM pantries WHERE building_id=? AND item_id=?");
    mysqli_stmt_bind_param($in_pantry_query, "ii", $my_pantry_id, $item_id);
    mysqli_stmt_execute($in_pantry_query);
    mysqli_stmt_store_result($in_pantry_query);
    if (mysqli_stmt_num_rows($in_pantry_query)){
        $add_query = mysqli_prepare($GLOBALS['db'],
            "UPDATE pantries SET quantity=quantity + ? WHERE building_id=? AND item_id=?");
        mysqli_stmt_bind_param($add_query, "iii", $quantity, $my_pantry_id, $item_id);
        mysqli_stmt_execute($add_query);
        mysqli_stmt_close($add_query);
    } else {
        $add_query = mysqli_prepare($GLOBALS['db'],
            "INSERT INTO pantries(building_id, item_id, quantity) VALUES (?,?,?)");
        mysqli_stmt_bind_param($add_query, "iii", $my_pantry_id, $item_id, $quantity);
        mysqli_stmt_execute($add_query);
        mysqli_stmt_close($add_query);
    }

    mysqli_stmt_close($in_pantry_query);
    
    
}