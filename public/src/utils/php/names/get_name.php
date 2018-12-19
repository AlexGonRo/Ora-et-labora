<?php

function get_region_name($region_id){
    $resource_name_query = mysqli_prepare($GLOBALS['db'],
        'SELECT name '
            . 'FROM regions '
            . 'WHERE id = ? LIMIT 1');
    mysqli_stmt_bind_param($resource_name_query, "i", $region_id);
    mysqli_stmt_bind_result($resource_name_query, $region_name);
    mysqli_stmt_execute($resource_name_query);
    mysqli_stmt_fetch($resource_name_query);
    mysqli_stmt_close($resource_name_query);
    
    return $region_name;
}

function get_username($user_id){
    $username_query = mysqli_prepare($GLOBALS['db'],
        'SELECT username FROM users WHERE id=?');
    mysqli_stmt_bind_param($username_query, "i", $user_id);
    mysqli_stmt_bind_result($username_query, $my_username);
    mysqli_stmt_execute($username_query);
    mysqli_stmt_fetch($username_query);
    mysqli_stmt_close($username_query);

    return $my_username;
}

function get_town_name($town_id){
    $town_name_query = mysqli_prepare($GLOBALS['db'],
        'SELECT name '
            . 'FROM towns '
            . 'WHERE id = ? LIMIT 1');
    mysqli_stmt_bind_param($town_name_query, "i", $town_id);
    mysqli_stmt_bind_result($town_name_query, $town_name);
    mysqli_stmt_execute($town_name_query);
    mysqli_stmt_fetch($town_name_query);
    mysqli_stmt_close($town_name_query);
    
    return $town_name;
}

function get_town_complete_name_by_id($town_id){
    
    $town_name_query = mysqli_prepare($GLOBALS['db'],
        'SELECT name, type '
            . 'FROM towns '
            . 'WHERE id = ? LIMIT 1');
    mysqli_stmt_bind_param($town_name_query, "i", $town_id);
    mysqli_stmt_bind_result($town_name_query, $town_name, $type);
    mysqli_stmt_execute($town_name_query);
    mysqli_stmt_fetch($town_name_query);
    mysqli_stmt_close($town_name_query);
    
    if($type==0){
        return "Pueblo de $town_name";
    } else {
        return "Villa de $town_name";
    }
}