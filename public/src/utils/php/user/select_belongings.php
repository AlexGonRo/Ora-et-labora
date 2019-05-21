<?php

require_once BASE_PATH_PUBLIC.'src/utils/php/land_res/get_res_name.php';

require_once BASE_PATH_PUBLIC.'src/private/vars/building_vars.php';

function select_towns($user_id){
    
    //Let's make a list of all our towns
    $towns_query = mysqli_prepare($GLOBALS['db'],
        'SELECT a.id, a.name, a.type, b.name, a.population '
            . 'FROM towns AS a INNER JOIN regions AS b ON a.region_id = b.id '
            . 'WHERE a.owner_id=? '
            . 'ORDER BY a.id');
    mysqli_stmt_bind_param($towns_query, "i", $user_id);
    mysqli_stmt_bind_result($towns_query, $id, $name, $type, $region_name, $pop);
    mysqli_stmt_execute($towns_query);

    $towns = array();
    while(mysqli_stmt_fetch($towns_query)) {
        $tmp = array('id' => $id,
            'name' => $name,
            'type' => $type,
            'region_name' => $region_name,
            'pop' => round($pop)
        );
        array_push($towns, $tmp);
    }
    mysqli_stmt_close($towns_query);
    
    return $towns; 
}

function select_resources($user_id){

    //Let's make a list of all our land resources
    $resources_query = mysqli_prepare($GLOBALS['db'],
        'SELECT a.id as resource_id,  b.name as region_name, c.name as resource_name '
            . 'FROM land_resources as a INNER JOIN regions AS b ON a.region_id = b.id INNER JOIN land_resources_info AS c ON c.id=a.resource '
            . 'WHERE a.owner_id=? ORDER BY a.id');
    mysqli_stmt_bind_param($resources_query, "i", $user_id);
    mysqli_stmt_bind_result($resources_query, $resource_id, $region_name, $resource_name);
    mysqli_stmt_execute($resources_query);

    $resources = array();
    while(mysqli_stmt_fetch($resources_query)) {
        $tmp = array('resource_id' => $resource_id,
            'region_name' => $region_name,
            'resource_name' => get_res_type_name($resource_name));
        array_push($resources, $tmp);
    }
    mysqli_stmt_close($resources_query);

    
    return $resources;
    
}

function get_ware_pantry($user_id){
    
    $get_ids_query = mysqli_prepare($GLOBALS['db'],
        "SELECT id, building_id "
            . "FROM buildings "
            . "WHERE owner_id=? AND (building_id=".WAREHOUSE_ID." OR building_id=".PANTRY_ID.")");
    mysqli_stmt_bind_param($get_ids_query, "i", $user_id);
    mysqli_stmt_bind_result($get_ids_query, $user_building_id, $building_id);
    mysqli_stmt_execute($get_ids_query);

    while (mysqli_stmt_fetch($get_ids_query)){
        if ($building_id == PANTRY_ID){
          $pantry_id = $user_building_id;
        } else {
          $ware_id = $user_building_id;
        }
    }

    mysqli_stmt_close($get_ids_query);
    
    return array($ware_id, $pantry_id);
            
}