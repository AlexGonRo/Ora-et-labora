<?php

require_once BASE_PATH_PUBLIC.'src/utils/php/time/get_ingame_time.php';
require_once BASE_PATH_PUBLIC.'src/private/vars/land_resources_vars.php';
require_once BASE_PATH_PUBLIC.'src/private/vars/item_vars.php';

function produce($db, $resource_id, $resource_main_id, $level, $status, $n_workers){
    
    
    if ($resource_main_id == FIELD_RES_ID)
        $production = field_prod($db, $resource_id, $level, $status, $n_workers);
    else if ($resource_id == FOREST_RES_ID)
        $production = forest_prod($db, $status, $n_workers);
    else if ($resource_id == COAST_RES_ID)
        $production = coast_prod($db, $level, $status, $n_workers);
    else if ($resource_id == QUARRY_RES_ID)
        $production = quarry_prod($db, $level, $status, $n_workers);
    else if ($resource_id == GOLD_RES_ID)
        $production = gold_mine_prod($db, $level, $status, $n_workers);
    else if ($resource_id == IRON_RES_ID)
        $production = iron_mine_prod($db, $level, $status, $n_workers);
    else if ($resource_id == SILVER_RES_ID)
        $production = silver_mine_prod($db, $level, $status, $n_workers);
    else if ($resource_id == COPPER_RES_ID)
        $production = copper_mine_prod($db, $level, $status, $n_workers);
    else if ($resource_id == RIVER_RES_ID)
        $production = river_prod($db, $level, $status, $n_workers);
    else if ($resource_id == CLAY_RES_ID)
        $production = clay_mine_prod($db, $level, $status, $n_workers);
        
    return $production;
                
}

function field_prod($db, $resource_id, $level, $status, $n_workers){
    
    # Check if field is currently producing something
    $field_query = mysqli_prepare($db,
            'SELECT growing, ready, start, end '
                . 'FROM field_resource AS a INNER JOIN field_resource_info AS b ON a.growing=b.id '
                . 'WHERE a.resource_id=?');
    mysqli_stmt_bind_param($field_query, 'i', $resource_id);
    mysqli_stmt_bind_result($field_query, $growing, $ready, $start, $end);
    mysqli_stmt_execute($field_query);
    mysqli_stmt_fetch($field_query);
    mysqli_stmt_close($field_query);
    
    list($day, $month, $year) = get_ingame_time();

    # If we can harvest
    if ($ready && $month >= $start && $month <= $end) {
        if ($growing == CATTLE_RAISING_ID){
            $production[MEAT_ID] = round(($n_workers*FIELD_EFF_MEAT) * LVL_BONUS_RES[$level-1] * $status/100);
            $production[MILK_ID] = round(($n_workers*FIELD_EFF_MILK) * LVL_BONUS_RES[$level-1] * $status/100);
            $production[WOOL_ID] = round(($n_workers*FIELD_EFF_WOOL) * LVL_BONUS_RES[$level-1] * $status/100);
        } else if ($growing == GRAIN_PROD_ID){
            $production[GRAIN_ID] = round(($n_workers*FIELD_EFF_GRAIN) * LVL_BONUS_RES[$level-1] * $status/100);
        } else if($growing == GRAPE_PROD_ID){
            $production[GRAPE_ID] = round(($n_workers*FIELD_EFF_GRAPE) * LVL_BONUS_RES[$level-1] * $status/100);
        }
    }
    

    return $production;
}

function forest_prod($db, $level, $status, $n_workers){

    $production[WOOD_ID] = round(($n_workers*FOREST_EFF_WOOD) * LVL_BONUS_RES[$level-1] * $status/100);
    $production[MEAT_ID] = round(($n_workers*FOREST_EFF_MEAT) * LVL_BONUS_RES[$level-1] * $status/100);        
    return $production;
}

function coast_prod($db, $level, $status, $n_workers){

    $production[MEAT_ID] = round(($n_workers*COAST_EFF_MEAT) * LVL_BONUS_RES[$level-1] * $status/100);  
    return $production;
}

function quarry_prod($db, $level, $status, $n_workers){

    $production[STONE_ID] = round(($n_workers*QUARRY_EFF_STONE) * LVL_BONUS_RES[$level-1] * $status/100);
    return $production;
}

function gold_mine_prod($db, $level, $status, $n_workers){

    $production[GOLD_ID] = round(($n_workers*GOLD_MINE_EFF_GOLD) * LVL_BONUS_RES[$level-1] * $status/100);
    return $production;
}

function iron_mine_prod($db, $level, $status, $n_workers){

    $production[IRON_ID] = round(($n_workers*IRON_MINE_EFF_IRON) * LVL_BONUS_RES[$level-1] * $status/100);
    return $production;
}

function silver_mine_prod($db, $level, $status, $n_workers){

    $production[SILVER_ID] = round(($n_workers*SILVER_MINE_EFF_SILVER) * LVL_BONUS_RES[$level-1] * $status/100);
    return $production;
}

function copper_mine_prod($db, $level, $status, $n_workers){

    $production[COPPER_ID] = round(($n_workers*COPPER_MINE_EFF_COPPER) * LVL_BONUS_RES[$level-1] * $status/100);
    return $production;
}

function river_prod($db, $level, $status, $n_workers){

    $production[MEAT_ID] = round(($n_workers*RIVER_EFF_MEAT) * LVL_BONUS_RES[$level-1] * $status/100);  
    return $production;
}

function clay_mine_prod($db, $level, $status, $n_workers){

    $production[CLAY_ID] = round(($n_workers*CLAY_MINE_EFF_CLAY) * LVL_BONUS_RES[$level-1] * $status/100);
    return $production;
}