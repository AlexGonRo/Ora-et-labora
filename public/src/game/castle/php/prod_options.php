<?php

function prod_options($building_id){
    
    $item_imgs = array();   # Stores the image paths to every item (either a main item or one that forms part of an item recipe)
    
    # Get the names of all the items that can be produced in $building_id
    $get_prod_list_query = mysqli_prepare($GLOBALS['db'],
        'SELECT id, name, img '
            . 'FROM item_info '
            . 'WHERE produced=? ORDER BY id');
    mysqli_stmt_bind_param($get_prod_list_query, "i", $building_id);
    mysqli_stmt_bind_result($get_prod_list_query, $item_id, $item_name, $item_img);
    mysqli_stmt_execute($get_prod_list_query);

    $recipes_array = array();
    $recipe_names_array = array();
    while(mysqli_stmt_fetch($get_prod_list_query)){
        $recipes_array[$item_id] = array();
        $recipe_names_array[$item_name] = array();
        $item_imgs[$item_name] = $item_img;
    };
    
    mysqli_stmt_close($get_prod_list_query);
    
    
    # Get the recipes for all the selected items
    $item_qm = implode(',', array_fill(0, count($recipes_array), '?'));
    $item_types = implode('', array_fill(0, count($recipes_array), 'i'));
    
    $get_ing_query = mysqli_prepare($GLOBALS['db'],
        'SELECT item_recipes.item_id, a.name as item_name, item_recipes.ingredient_id, b.name as ingredient_name, b.img, quantity '
            . 'FROM item_recipes INNER JOIN item_info AS a ON item_recipes.item_id = a.id INNER JOIN item_info b ON b.id=item_recipes.ingredient_id '
            . 'WHERE item_recipes.item_id IN ('. $item_qm .') ORDER BY item_id');
    mysqli_stmt_bind_param($get_ing_query, $item_types, ...array_keys($recipes_array));
    mysqli_stmt_bind_result($get_ing_query, $item_id, $item_name, $ingredient_id, $ingredient_name, $ingredient_img, $quantity);
    mysqli_stmt_execute($get_ing_query);
    
    while (mysqli_stmt_fetch($get_ing_query)){
        $recipes_array[$item_id][] = array($ingredient_id, $quantity);
        $recipe_names_array[$item_name][] = array($ingredient_name, $quantity);
        $item_imgs[$ingredient_name] = $ingredient_img;
    }
    mysqli_stmt_close($get_ing_query);
    
   return array($recipes_array, $recipe_names_array, $item_imgs);
}

