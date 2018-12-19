<?php

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
