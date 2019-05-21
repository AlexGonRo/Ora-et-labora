<?php

/**
 * Individual functions that look for specific alerts
 */
// TODO CHANGE ALL THESE PREDEFINED MESSAGES

require_once BASE_PATH_PUBLIC.'src/utils/php/building/compute_space.php';
require_once BASE_PATH_PUBLIC.'src/utils/php/building/building_exists.php';
require_once BASE_PATH_PUBLIC.'src/private/vars/building_vars.php';

function workers_busy(){
    
    $alert = array();
            
    // Check if all workers have a task
    $lazy_worker_query = mysqli_prepare($GLOBALS['db'],
        "SELECT task FROM workers WHERE owner_id=? AND (task IS NULL OR task='ninguna')");
    mysqli_stmt_bind_param($lazy_worker_query, "i", $_SESSION['user_id']);
    mysqli_stmt_execute($lazy_worker_query);
    mysqli_stmt_store_result($lazy_worker_query);    

    if ( mysqli_stmt_num_rows($lazy_worker_query)){
        $alert = array(
            'img' => BASE_PATH_PUBLIC.'img/icons/other/alert.png',
            'msg' => "Algunos de tus trabajadores no tienen una función asignada.",
            'url' => "../castle/workers.php");
    }
    mysqli_stmt_close($lazy_worker_query);
    
    return $alert;
    
}


function pantry_full(){
    $alert = array();
    list($pantry_occupied, $pantry_max_cap) = compute_pantry_space($GLOBALS['db'], $_SESSION['user_id']);
    
    if($pantry_occupied >= $pantry_max_cap){
        $alert = array(
            'img' => BASE_PATH_PUBLIC."img/icons/other/alert.png",
            'msg' => "La despensa está totalmente llena.",
            'url' => "");
    }
    else if($pantry_occupied / $pantry_max_cap >= 0.9){
        $alert = array(
            'img' => BASE_PATH_PUBLIC."img/icons/other/warning.png",
            'msg' => "La despensa está casi llena.",
            'url' => "");
    }
    
    
    return $alert;
}

function warehouse_full(){
    $alert = array();
    list($ware_occupied, $ware_max_cap) = compute_warehouse_space($GLOBALS['db'], $_SESSION['user_id']);
    
    if($ware_occupied >= $ware_max_cap){
        $alert = array(
            'img' => BASE_PATH_PUBLIC."img/icons/other/alert.png",
            'msg' => "El almacén está totalmente lleno.",
            'url' => "");
    }
    else if($ware_occupied / $ware_max_cap >= 0.9){
        $alert = array(
            'img' => BASE_PATH_PUBLIC."img/icons/other/warning.png",
            'msg' => "El almacén está casi lleno.",
            'url' => "");
    }
    
    return $alert;
    
}



function unused_garden_field($user_id){
    $alert = array();
    
    if (garden_exists($user_id)){
        // Check if any of the fields isn't planted
        $unused_fields_query = mysqli_prepare($GLOBALS['db'],
            "SELECT id "
                . "FROM gardens AS a INNER JOIN buildings AS b ON (a.building_id=b.id) "
                . "WHERE b.owner_id=? AND b.building_id=".GARDEN_ID." AND a.growing=0");        // TODO This "0" is hardcoded here
        mysqli_stmt_bind_param($unused_fields_query, "i", $user_id);
        mysqli_stmt_execute($unused_fields_query);
        mysqli_stmt_store_result($unused_fields_query);    

        if ( mysqli_stmt_num_rows($unused_fields_query)){
            $alert = array(
                'img' => BASE_PATH_PUBLIC.'img/icons/other/warning.png',
                'msg' => "Tienes espacio sin cultivar en la huerta.",
                'url' => "../castle/garden.php");
        }
        mysqli_stmt_close($unused_fields_query);
    
    }
    return $alert;
}

function unused_space_stable($user_id){
    $alert = array();
    if (stable_exists($user_id)){
        // Can we have more animals here?
                // Check if any of the fields isn't planted
        $unused_space_query = mysqli_prepare($GLOBALS['db'],
            "SELECT SUM(max_pop) "
                . "FROM stables AS a INNER JOIN buildings AS b ON (a.building_id=b.id) "
                . "WHERE b.owner_id=? AND b.building_id=".STABLE_ID);        // TODO This "0" is hardcoded here
        mysqli_stmt_bind_param($unused_space_query, "i", $user_id);
        mysqli_stmt_bind_result($unused_space_query, $used_space);
        mysqli_stmt_execute($unused_space_query);
        mysqli_stmt_store_result($unused_space_query);    

        if ( mysqli_stmt_num_rows($unused_space_query)){
            if($used_space < 100){
                $alert = array(
                    'img' => BASE_PATH_PUBLIC.'img/icons/other/warning.png',
                    'msg' => "Tienes espacio sin asignar en la granja.",
                    'url' => "../castle/animals.php");
            }
        }
        mysqli_stmt_close($unused_space_query);
    }
    
    return $alert;
    
}