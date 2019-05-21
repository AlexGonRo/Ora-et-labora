<?php

require_once BASE_PATH_PUBLIC.'src/private/vars/item_vars.php';
require_once BASE_PATH_PUBLIC.'src/private/vars/building_vars.php';

require_once BASE_PATH_PUBLIC.'src/utils/php/user/select_belongings.php';

function consume_items($user_id, $res_array){
    
    # Get user's warehouse and pantry id
    list($my_warehouse_id, $my_pantry_id) = get_ware_pantry($user_id);
    
    foreach ($res_array as $item_id => $quantity){
        if ($item_id == MONEY_ID){
            $update_money_query = mysqli_prepare($GLOBALS['db'],
                "UPDATE users SET money = money - ? WHERE id=?");
            mysqli_stmt_bind_param($update_money_query, "ii", $quantity, $user_id);
            mysqli_stmt_execute($update_money_query);
            mysqli_stmt_close($update_money_query);

        }
        else if (in_array($item_id, WAREHOUSE_ITEMS)){
            $update_ware_query = mysqli_prepare($GLOBALS['db'],
                "UPDATE warehouses SET quantity = quantity - ? WHERE building_id=? AND item_id = ? ");
            mysqli_stmt_bind_param($update_ware_query, "iii", $quantity, $my_warehouse_id, $item_id);
            mysqli_stmt_execute($update_ware_query);
            mysqli_stmt_close($update_ware_query);
            // Remove entry from DB if quantity is 0
            $delete_zero_query = mysqli_prepare($GLOBALS['db'],
                "DELETE FROM warehouses WHERE building_id=? AND item_id = ? AND quantity=0");
            mysqli_stmt_bind_param($delete_zero_query, "ii", $my_warehouse_id, $item_id);
            mysqli_stmt_execute($delete_zero_query);
            mysqli_stmt_close($delete_zero_query);

        } else {
            $update_pantry_query = mysqli_prepare($GLOBALS['db'],
                "UPDATE pantries SET quantity = quantity - ? WHERE building_id=? AND item_id = ? ");
            mysqli_stmt_bind_param($update_pantry_query, "iii", $quantity, $my_pantry_id, $item_id);
            mysqli_stmt_execute($update_pantry_query);
            mysqli_stmt_close($update_pantry_query);
            // Remove entry from DB if quantity is 0
            $delete_zero_query = mysqli_prepare($GLOBALS['db'],
                "DELETE FROM pantries WHERE building_id=? AND item_id = ? AND quantity=0");
            mysqli_stmt_bind_param($delete_zero_query, "ii", $my_pantry_id, $item_id);
            mysqli_stmt_execute($delete_zero_query);
            mysqli_stmt_close($delete_zero_query);
            
        }
    }
}

