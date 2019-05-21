<?php
require_once BASE_PATH_PUBLIC.'src/utils/php/item_management/has_resources.php';
require_once BASE_PATH_PUBLIC.'src/private/vars/building_vars.php';

function can_lvlup($free_space, $user_id, $required_resources, $building_id){
    # 

    # Check that there is enough building space
    if ($free_space <= 0){
        return False;
    }
    # Check that the building is not currently under construction
    $building_info_query = mysqli_prepare($GLOBALS['db'],
        'SELECT * FROM buildings_current_lvlups WHERE user_building_id=?');
    mysqli_stmt_bind_param($building_info_query, "i", $building_id);
    mysqli_stmt_execute($building_info_query);
    mysqli_stmt_store_result($building_info_query);
    if (mysqli_stmt_num_rows($building_info_query) != 0 ){
        return False;
    }
    mysqli_stmt_close($building_info_query);
    
    
    # Check that there are enough resources
    $flag = has_resources($user_id, $required_resources);
    
    
    return $flag;
}


function can_build($free_space, $user_id, $required_resources, $building_id){

    return can_lvlup($free_space + EXISTENCE_BUILDING_SPACE, $user_id, 
            $required_resources, $building_id);
    
    
}