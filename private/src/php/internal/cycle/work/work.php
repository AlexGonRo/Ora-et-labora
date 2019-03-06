<?php

require_once BASE_PATH_PUBLIC.'src/private/vars/building_vars.php';
require_once BASE_PATH_PUBLIC.'src/private/vars/item_vars.php';
require_once BASE_PATH_PUBLIC.'src/utils/php/item_management/has_resources.php';
require_once BASE_PATH_PUBLIC.'src/utils/php/item_management/get_item_info.php';
require_once BASE_PATH_PUBLIC.'src/utils/php/item_management/add_items.php';
require_once BASE_PATH_PUBLIC.'src/utils/php/item_management/consume_items.php';

function work($db, $strenght, $dexterity, $charisma, $owner_id, $task){
    if ($task == 'cocinar')
        cook_prod($db, $strenght, $dexterity, $owner_id);
    else if ($task =='talar')
        chop_prod($db, $strenght, $owner_id);
    else if ($task =='pastorear')
        herd_prod($db, $dexterity, $owner_id);
    else if ($task =='labrar')
        cultivate_prod($db, $strenght, $dexterity, $owner_id);
    else if ($task =='oficiar_misa')
        mass_prod($db, $charisma, $owner_id);
    else if ($task =='ninguna')
        return ;
}

function cook_prod($db, $strenght, $dexterity, $user_id){
    
    # Get user's kitchen id
    $kitchen_query = mysqli_prepare($GLOBALS['db'],
        'SELECT id, level FROM buildings WHERE owner_id = ? AND building_id = '.KITCHEN_ID);
    mysqli_stmt_bind_param($kitchen_query, 'i', $user_id );
    mysqli_stmt_bind_result($kitchen_query, $my_kitchen_id, $level);
    mysqli_stmt_execute($kitchen_query);
    mysqli_stmt_fetch($kitchen_query);
    mysqli_stmt_close($kitchen_query);
    
    # How much "working force" this worker has?
    $workforce = $strenght * ($dexterity*2) * LVL_BONUS_BUILDINGS[$level];

    # What's there to cook?
    $cook_query = mysqli_prepare($GLOBALS['db'],
            'SELECT a.id, item_id, quantity, effort '
                . 'FROM user_prod AS a INNER JOIN item_info AS b ON a.item_id=b.id '
                . 'WHERE user_building_id=? '
                . 'ORDER BY a.id');
    mysqli_stmt_bind_param($cook_query, 'i', $my_kitchen_id );
    mysqli_stmt_bind_result($cook_query, $prod_id, $item_id, $quantity, $effort);
    mysqli_stmt_execute($cook_query);
    mysqli_stmt_store_result($cook_query);
    
    while (mysqli_stmt_fetch($cook_query)){
        
        $prod_quantity = $quantity; // Quantity of the item we are finally producing
        
        # Do we have the resources to continue production? And enough space to store the resulting products? And enough workforce?
        
        # Check space
        if (in_array($item_id, WAREHOUSE_ITEMS)){
            # Check warehouse free space
            list($occupied, $max_cap) = compute_warehouse_space($GLOBALS['db'], $user_id);
        } else {               
            # Check pantry free space
            list($occupied, $max_cap) = compute_pantry_space($GLOBALS['db'], $user_id);
        }
        
        $free_space = $max_cap - $occupied;

        if ($free_space < $quantity ) {# If it can only store part of $quantity (or nothing at all)...
            $prod_quantity = $quantity - ($quantity - $free_space); 
            if ($prod_quantity <= 0){
                return;
            } 
        }
        
        
        # Check resouces
        
        # Get recipe
        $recipe = get_item_recipe($item_id);
        # Check if we have resources
        $n_items_produced = compute_number_items_produced($user_id, $recipe);
        # update prod_quantity and exit if it's equal 0
        if ($n_items_produced < $prod_quantity) {
            $prod_quantity = $n_items_produced;
            if ($prod_quantity <= 0){
                return;
            }
        }
        
        # Check workforce
        $n_items_produced = floor($workforce/$effort);
        if ($n_items_produced < $prod_quantity) {
            $prod_quantity = $n_items_produced;
            if ($prod_quantity <= 0){
                return;
            }
        }
            
        # Compute how many resources in total we are spending
        $final_res_consumption = array();
        foreach ($recipe as $i_id => $q){
            $final_res_consumption[$i_id] = $q*$prod_quantity;
        }
        
        
        # Consume resources     
        consume_items($user_id, $final_res_consumption);
        # Produce and store
        if (in_array($item_id, WAREHOUSE_ITEMS)){
            $warehouse_id_query = mysqli_prepare($GLOBALS['db'],
                "SELECT id FROM buildings WHERE building_id=".WAREHOUSE_ID." AND owner_id = ?");
            mysqli_stmt_bind_param($warehouse_id_query, "i", $user_id);
            mysqli_stmt_bind_result($warehouse_id_query, $my_warehouse_id);
            mysqli_stmt_execute($warehouse_id_query);
            mysqli_stmt_fetch($warehouse_id_query);
            mysqli_stmt_close($warehouse_id_query);
            add_to_warehouse($user_id, $my_warehouse_id, $item_id, $prod_quantity);
        } else {
            $pantry_id_query = mysqli_prepare($GLOBALS['db'],
                "SELECT id FROM buildings WHERE building_id=".PANTRY_ID." AND owner_id = ?");
            mysqli_stmt_bind_param($pantry_id_query, "i", $user_id);
            mysqli_stmt_bind_result($pantry_id_query, $my_pantry_id);
            mysqli_stmt_execute($pantry_id_query);
            mysqli_stmt_fetch($pantry_id_query);
            mysqli_stmt_close($pantry_id_query);
            add_to_pantry($user_id, $my_pantry_id, $item_id, $prod_quantity);
        }
        
        # Remove production from the production list
        if ($prod_quantity == $quantity){
            $rm_prod_query = mysqli_prepare($GLOBALS['db'],
                "DELETE FROM user_prod "
                    . "WHERE id = ?");
            mysqli_stmt_bind_param($rm_prod_query, "i", $prod_id);
            mysqli_stmt_execute($rm_prod_query);
            mysqli_stmt_close($rm_prod_query);
        } else {
            $upd_prod_query = mysqli_prepare($GLOBALS['db'],
                "UPDATE user_prod "
                    . "SET quantity = quantity - $prod_quantity "
                    . "WHERE id = ?");
            mysqli_stmt_bind_param($upd_prod_query, "i", $prod_id);
            mysqli_stmt_execute($upd_prod_query);
            mysqli_stmt_close($upd_prod_query);
        }
        
        # Is there workfoce left?
        $workforce -= $effort*$prod_quantity;
        if ($workforce < 10){       // TODO Hardcoded value
            break;
        }
        
    }
    mysqli_stmt_close($cook_query);
}

function chop_prod($db, $strenght, $owner_id){
    # TODO unimplemented
}

function herd_prod($db, $dexterity, $owner_id){
    # TODO unimplemented
}

function cultivate_prod($db, $strenght, $dexterity, $owner_id){
    # TODO unimplemented
}

function mass_prod($db, $charisma, $owner_id){
    //TODO Unimplemented
    
}
