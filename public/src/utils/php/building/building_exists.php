<?php

require_once BASE_PATH_PUBLIC.'src/private/vars/building_vars.php';



function garden_exists($user_id){
    
    $exists = false;
    
    $garden_query = mysqli_prepare($GLOBALS['db'],
        "SELECT id "
            . "FROM buildings "
            . "WHERE owner_id = ? AND building_id = ".GARDEN_ID);
    mysqli_stmt_bind_param($garden_query, "i", $user_id);
    mysqli_stmt_execute($garden_query);
    mysqli_stmt_store_result($garden_query);    

    if ( mysqli_stmt_num_rows($garden_query)){
        $exists = true;
    }
    mysqli_stmt_close($garden_query);
    
    return exists;
}

function stable_exists(){
    
    $exists = false;
    
    $stable_query = mysqli_prepare($GLOBALS['db'],
        "SELECT id "
            . "FROM buildings "
            . "WHERE owner_id = ? AND building_id = ".STABLE_ID);
    mysqli_stmt_bind_param($stable_query, "i", $user_id);
    mysqli_stmt_execute($stable_query);
    mysqli_stmt_store_result($stable_query);    

    if ( mysqli_stmt_num_rows($stable_query)){
        $exists = true;
    }
    mysqli_stmt_close($stable_query);
    
    return exists;
    
}