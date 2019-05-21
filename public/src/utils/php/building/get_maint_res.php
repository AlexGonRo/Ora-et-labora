<?php
require_once BASE_PATH_PUBLIC.'src/private/vars/building_vars.php';

function get_building_maint_res($building_id, $level) {
        $building_maint_query = mysqli_prepare($GLOBALS['db'],
        'SELECT item_id, quantity '
            . 'FROM buildings_lvlup_res '
            . 'WHERE building_id=? AND level = ? ORDER BY item_id');
    mysqli_stmt_bind_param($building_maint_query, "ii", $building_id, $level);
    mysqli_stmt_bind_result($building_maint_query, $item_id, $quantity);
    mysqli_stmt_execute($building_maint_query);
    $maint_array = array();
    while (mysqli_stmt_fetch($building_maint_query)) {
        $maint_array[$item_id] = floor($quantity*PERC_MAINT);
    }
    mysqli_stmt_close($building_maint_query);
    
    return $maint_array;
}
