<?php





/**
 * Given a list of item ids returns all available information about those items.
 * 
 * @param array(int) $item_ids
 * @return associative array
 */
function get_items_info($item_ids){
    
    $items_info = array();
    
    $items_qm = implode(',', array_fill(0, count($item_ids), '?'));
    $item_types = implode('', array_fill(0, count($item_ids), 'i'));
    
    $items_query = mysqli_prepare($GLOBALS['db'],
        'SELECT id, name, img, effort, produced, stored_in, class '
            . 'FROM item_info WHERE id IN ('.$items_qm.')');
    mysqli_stmt_bind_param($items_query, $item_types, ...$item_ids);
    mysqli_stmt_bind_result($items_query, $id, $name, $img, $effort, $produced, $stored_in, $class);
    mysqli_stmt_execute($items_query);

    while (mysqli_stmt_fetch($items_query)) {
        $items_info[] = array(
            'item_id' => $id,
            'item_name' => $name,
            'item_ing' => $img,
            'item_effort' => $effort,
            'item_produced' => $produced,
            'item_stored_in' => $stored_in,
            'item_class' => $class
        );
    }
    mysqli_stmt_close($items_query);
    
    return $items_info;
}


/**
 * Given a list of item ids return the name of the items.
 * 
 * @param array(int) $item_ids
 * @return associative array
 */
function get_item_names($item_ids){
    
    $items_qm = implode(',', array_fill(0, count($item_ids), '?'));
    $item_types = implode('', array_fill(0, count($item_ids), 'i'));
    
    $items_query = mysqli_prepare($GLOBALS['db'],
        'SELECT name FROM item_info WHERE id IN ('.$items_qm.')');
    mysqli_stmt_bind_param($items_query, $item_types, ...$item_ids);
    mysqli_stmt_bind_result($items_query, $item_name);
    mysqli_stmt_execute($items_query);
    $names = array();
    $i = 0;
    while (mysqli_stmt_fetch($items_query)) {
        $names[$item_ids[$i]] = $item_name;
        $i++;
    }
    mysqli_stmt_close($items_query);
    
    return $names;
}



/**
 * Given a list of items return the path to their corresponding icon.
 * 
 * @param array(int) $item_ids
 * @return array(int, str)
 */
function get_item_icons($item_ids){
    
    $items_qm = implode(',', array_fill(0, count($item_ids), '?'));
    $item_types = implode('', array_fill(0, count($item_ids), 'i'));
    
    $items_query = mysqli_prepare($GLOBALS['db'],
        'SELECT name, img FROM item_info WHERE id IN ('.$items_qm.')');
    mysqli_stmt_bind_param($items_query, $item_types, ...$item_ids);
    mysqli_stmt_bind_result($items_query, $item_name, $item_icon);
    mysqli_stmt_execute($items_query);
    $icons = array();
    $i = 0;
    while (mysqli_stmt_fetch($items_query)) {
        $icons[$item_ids[$i]] = $item_icon;
        $i++;
    }
    mysqli_stmt_close($items_query);
    
    return $icons;
}

/**
 * Returns the recipe (list of ingredients and quantities) to elaborate a certain item.
 * 
 * @param int $item_id
 * @return array(int, int) List of ingredients (index: id of ingredient; value: quantity)
 */
function get_item_recipe($item_id){
    
    $items_query = mysqli_prepare($GLOBALS['db'],
        'SELECT ingredient_id, quantity FROM item_recipes WHERE item_id = ?');
    mysqli_stmt_bind_param($items_query, 'i', $item_id);
    mysqli_stmt_bind_result($items_query, $ingredient_id, $quantity);
    mysqli_stmt_execute($items_query);
    $recipe = array();
    while (mysqli_stmt_fetch($items_query)) {
        $recipe[$ingredient_id] = $quantity;
    }
    mysqli_stmt_close($items_query);
    
    return $recipe;
}

