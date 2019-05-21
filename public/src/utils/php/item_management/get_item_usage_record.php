<?php



/**
 * Get detailed info about a user's item production/consumption in a given time
 * period.
 * 
 * @param int $item_class Class the items belong to.
 * @param int $balance_cycles Number of cycles we'll consider when making the balance.
 * @return Associative array with information about different items.
 */
function get_balance_info($item_class, $balance_cycles){
    
    // Which date is today?

    $current_cycle = get_ingame_cycle();
    
    
    // Get info about the production

    $prod_record = get_prod_record($item_class, $_SESSION['user_id'], $current_cycle, $balance_cycles);


    // Get info about the expense

    $consumed_record = get_consumed_record(RAW_FOOD_CLASS, $_SESSION['user_id'], $current_cycle, $balance_cycles);


    // Put all that info together and add item name and image
    
    $item_indexes = array_merge(array_keys($prod_record), array_keys($consumed_record));
    
    if(sizeof($item_indexes) > 0){
        $items_info = get_items_info($item_indexes);
        $items_balance = array();
        foreach($item_indexes as $i){

            $items_balance[] = array(
                'item_id' => $i,
                'item_name' => $items_info[$i]['item_name'],
                'item_img' => $items_info[$i]['item_img'],
                'prod' => $prod_record[$i],
                'consumed' => $consumed_record[$i],
                'balance' => $prod_record[$i] - $consumed_record[$i]

            );
        }

        return $items_balance;
    } else {    // If there isn't any item production or consumption
        return array();
    }
    
    
    
}



/**
 * Get an array of all the items included in a given category and produced by 
 * a user in a given time period.
 * 
 * @param int $item_class Class the items belong to
 * @param int $user_id
 * @param int $current_cycle
 * @param int $time_period Number of cycles to consider when returning the record.
 * 
 * @return array(int, int) Items produced and their quantities. Associative array, keys=item_id, value=quantity
 */
function get_prod_record($item_class, $user_id, $current_cycle, $time_period=1){
    
    $items_record = array();
    
    $get_items_query = mysqli_prepare($GLOBALS['db'],
        'SELECT a.item_id, a.quantity '
            . 'FROM prod_record AS a INNER JOIN item_info AS b ON a.item_id = b.id '
            . 'WHERE a.user_id=? AND ? <= ? - cycle AND b.class = ? '
            . 'ORDER BY a.item_id');
    mysqli_stmt_bind_param($get_items_query, "iiii", $user_id, $time_period, $current_cycle, $item_class);
    mysqli_stmt_bind_result($get_items_query, $item_id, $item_quantity);
    mysqli_stmt_execute($get_items_query);
    
    while (mysqli_stmt_fetch($get_items_query)){
        $items_record[$item_id] = $item_quantity;
    }
    mysqli_stmt_close($get_items_query);
    
    return $items_record;
    
}


/**
 * Get an array of all the items included in a given category and consumed by 
 * a user in a given time period.
 * 
 * @param int $item_class Class the items belong to
 * @param int $user_id
 * @param int $current_cycle
 * @param int $time_period Number of cycles to consider when returning the record.
 * 
 * @return array(int, int) Items consumed and their quantities. Associative array, keys=item_id, value=quantity
 */
function get_consumed_record($item_class, $user_id, $current_cycle, $time_period=1){
    
    $items_record = array();
    
    $get_items_query = mysqli_prepare($GLOBALS['db'],
        'SELECT a.item_id, a.quantity '
            . 'FROM consumed_record AS a INNER JOIN item_info AS b ON a.item_id = b.id '
            . 'WHERE a.user_id=? AND ? <= ? - cycle AND b.class = ? '
            . 'ORDER BY a.item_id');
    mysqli_stmt_bind_param($get_items_query, "iiii", $user_id, $time_period, $current_cycle, $item_class);
    mysqli_stmt_bind_result($get_items_query, $item_id, $item_quantity);
    mysqli_stmt_execute($get_items_query);
    
    while (mysqli_stmt_fetch($get_items_query)){
        $items_record[$item_id] = $item_quantity;
    }
    mysqli_stmt_close($get_items_query);
    
    return $items_record;
    
}
