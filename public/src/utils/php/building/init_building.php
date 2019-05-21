<?php

require_once BASE_PATH_PUBLIC.'src/private/vars/field_animal_vars.php';
/* 
 * Initialize buildings information when first built.
 */

function init_garden($user_id, $new_garden_id){
    
    // Remove any possible information that the table could have regarding this user (just in case)
    $rm_field_query = mysqli_prepare($GLOBALS['db'],
        "DELETE a FROM gardens AS a INNER JOIN buildings AS b ON a.building_id = b.id "
            . "WHERE b.owner_id = ?");
    mysqli_stmt_bind_param($rm_field_query, "i", $user_id);
    mysqli_stmt_execute($rm_field_query);
    mysqli_stmt_close($rm_field_query);
    
    
    // Create garden
    $create_garden_query = mysqli_prepare($GLOBALS['db'],
        "INSERT INTO gardens(building_id, growing, effectiveness, ready, picked_up) VALUES (?, 0, 0, 0, 0)");
    mysqli_stmt_bind_param($create_garden_query, "i", $new_garden_id);
    mysqli_stmt_execute($create_garden_query);
    mysqli_stmt_close($create_garden_query);
}

function init_stable($user_id, $new_stable_id){
    
    // Remove any possible information that the table could have regarding this user (just in case)
    $rm_stable_query = mysqli_prepare($GLOBALS['db'],
        "DELETE a FROM stables AS a INNER JOIN buildings AS b ON a.building_id = b.id "
            . "WHERE b.owner_id = ?");
    mysqli_stmt_bind_param($rm_stable_query, "i", $user_id);
    mysqli_stmt_execute($rm_stable_query);
    mysqli_stmt_close($rm_stable_query);
    
    
    // Create garden
    $create_stable_query = mysqli_prepare($GLOBALS['db'],
        "INSERT INTO stables(building_id, animal_id, pop, max_pop ) VALUES "
            . "(?, ".CHICKEN_ID.", 0, 0), "
            . "(?, ".GOOSE_ID.", 0, 0),"
            . "(?, ".PIG_ID.", 0, 0),"
            . "(?, ".SHEEP_ID.", 0, 0),"
            . "(?, ".COW_ID.", 0, 0),"
            . "(?, ".HORSE_ID.", 0, 0)");
    mysqli_stmt_bind_param($create_stable_query, "iiiiii", $new_stable_id, $new_stable_id, $new_stable_id, $new_stable_id, $new_stable_id, $new_stable_id);
    mysqli_stmt_execute($create_stable_query);
    mysqli_stmt_close($create_stable_query);
    
    
}