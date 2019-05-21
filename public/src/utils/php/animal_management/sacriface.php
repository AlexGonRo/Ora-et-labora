<?php

require_once BASE_PATH_PUBLIC.'src/utils/php/building/compute_space.php';
require_once BASE_PATH_PUBLIC.'src/utils/php/item_management/add_items.php';
require_once BASE_PATH_PUBLIC.'src/utils/php/user/select_belongings.php';

require_once BASE_PATH_PUBLIC.'src/private/vars/item_vars.php';


function sacrifice_animal($animal_id, $kill, $stable_id, $user_id){
    
    # Get user's warehouse and pantry
    list($my_ware_id, $my_pantry_id) = get_ware_pantry($user_id);
    
    
    # Get resources info resources
    $get_info_query = mysqli_prepare($db,
        'SELECT fur, meat, feather FROM stable_animals_info WHERE id = ?');
    mysqli_stmt_bind_param($get_info_query, "i", $animal_id);
    mysqli_stmt_bind_result($get_info_query, $fur, $meat, $feather);
    mysqli_stmt_execute($get_info_query);
    mysqli_stmt_fetch($get_info_query);
    mysqli_stmt_close($get_info_query);
    
    $res = array();
    $res[FUR_ID] = $fur*$kill;
    $res[MEAT_ID] = $meat*$kill;
    $res[FEATHER_ID] = $feather*$kill;    
    
    # Do we have enough space to keep all the resources?
    ## Check warehouse
    list($cur_space_ware, $max_cap_ware) = compute_warehouse_space($GLOBALS['db'], $user_id);
    if($cur_space_ware + $res[FUR_ID] + $res[FEATHER_ID] > $max_cap_ware){
        # We have no space!
        return -1;
    }
    ## Check pantry
    list($cur_space_pantry, $max_cap_pantry) = compute_pantry_space($GLOBALS['db'], $user_id);
    if($cur_space_pantry + $res[MEAT_ID] > $max_cap_pantry){
        # We have no space!
        return -1;
    }
    
    # Kill animals
    $kill_query = mysqli_prepare($db,
        'UPDATE stable SET pop=pop-? WHERE building_id = ? AND animal_id= ?');
    mysqli_stmt_bind_param($kill_query, "iii", $kill, $stable_id, $animal_id);
    mysqli_stmt_execute($kill_query);
    mysqli_stmt_fetch($kill_query);
    mysqli_stmt_close($kill_query);
    
    # Give resources to the user
    add_to_warehouse($user_id, $my_ware_id, FUR_ID, $res[FUR_ID]);
    add_to_warehouse($user_id, $my_ware_id, FEATHER_ID, $res[FEATHER_ID]);
    add_to_pantry($user_id, $my_pantry_id, MEAT_ID, $res[MEAT_ID]);
    
    return res;

}