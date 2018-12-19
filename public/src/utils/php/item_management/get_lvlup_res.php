<?php

/**
 * Get land resource lvlup items (and quantities)
 * @param type $resource_id
 * @param type $level
 * @return type
 */
function get_res_lvlup_resources($resource_id, $level){
    $res_lvlup_query = mysqli_prepare($GLOBALS['db'],
        'SELECT item_id, quantity FROM land_resources_lvlup_res as a INNER JOIN item_info as b ON b.id = a.item_id '
            . 'WHERE a.resource_id= ?  AND a.level = ? ORDER BY item_id');
    mysqli_stmt_bind_param($res_lvlup_query, "ii", $resource_id, $level);
    mysqli_stmt_bind_result($res_lvlup_query, $item_id, $quantity);
    mysqli_stmt_execute($res_lvlup_query);

    $lvlup_array = array();
    while (mysqli_stmt_fetch($res_lvlup_query)) {
        $lvlup_array[$item_id] = $quantity;
    }
    mysqli_stmt_close($res_lvlup_query);
    
    return $lvlup_array;
}

function get_town_building_lvlup_resources($town_building_id, $level){
    $building_lvlup_query = mysqli_prepare($GLOBALS['db'],
        'SELECT item_id, quantity '
            . 'FROM town_buildings_lvlup_res as a INNER JOIN item_info as b ON b.id = a.item_id '
            . 'WHERE a.building_id= ?  AND a.level = ? ORDER BY item_id');
    mysqli_stmt_bind_param($building_lvlup_query, "ii", $town_building_id, $level);
    mysqli_stmt_bind_result($building_lvlup_query, $item_id, $quantity);
    mysqli_stmt_execute($building_lvlup_query);

    $lvlup_array = array();
    while (mysqli_stmt_fetch($building_lvlup_query)) {
        $lvlup_array[$item_id] = $quantity;
    }
    mysqli_stmt_close($building_lvlup_query);
    
    return $lvlup_array;
}

function get_building_lvlup_resources($building_id, $level){
    $building_lvlup_query = mysqli_prepare($GLOBALS['db'],
        'SELECT b.id, a.quantity FROM buildings_lvlup_res AS a INNER JOIN item_info AS b ON b.id = a.item_id '
            . 'WHERE a.building_id=? AND level = ? ORDER BY item_id');
    mysqli_stmt_bind_param($building_lvlup_query, "ii", $building_id, $level);
    mysqli_stmt_bind_result($building_lvlup_query, $item_id, $quantity);
    mysqli_stmt_execute($building_lvlup_query);

    $lvlup_array = array();
    while (mysqli_stmt_fetch($building_lvlup_query)) {
        $lvlup_array[$item_id] = $quantity;
    }
    mysqli_stmt_close($building_lvlup_query);
    
    return $lvlup_array;
}