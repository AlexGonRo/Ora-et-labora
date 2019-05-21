<?php

require '../../../../../public/src/private/db_connect.php';

require '../../../../../public/src/private/vars/cycle_run_vars.php';
require '../../../../../public/src/private/vars/item_vars.php';
require '../../../../../public/src/private/vars/building_vars.php';

require '../../../../../public/src/utils/php/time/get_ingame_time.php';
require '../../../../../public/src/utils/php/item_management/add_items.php';

require 'town/update_pop.php';
require 'town/update_params.php';
require 'resource/produce.php';
require 'resource/distribute_villagers.php';
require 'resource/update_ready_fields.php';
require 'work/work.php';

# Delete old alerts
delete_old_alerts($db);

# Update time
update_time($db);

# Update town buildings or resources that are under construction
lvlup_town_buildings_resources($db);

# Update town's population and other towns variables
update_towns($db);
#Update effectiveness in land_resources and check if fields are prepared to be used
update_resources($db);

# Assign town's population to the land resources
pop_to_land_resources($db);


# Work the land resources
work_resources($db);


# Update personal buildings
lvlup_personal_buildings($db);


# Let's work!
work_internal($db);

# Update birthdays
update_birthdays($db);

# Check if we need to delete other users that decided to remove their accounts
delete_users($db);

# Delete inactive users
delete_inactive($db);





function delete_old_alerts($db){
    
    $del_alert_query = mysqli_prepare($db,
        'DELETE FROM alerts WHERE duration<=1');
    mysqli_stmt_execute($del_alert_query);
    mysqli_stmt_close($del_alert_query);
    
    $upd_alert_query = mysqli_prepare($db,
        'UPDATE alerts SET duration = duration - 1');
    mysqli_stmt_execute($upd_alert_query);
    mysqli_stmt_close($upd_alert_query);

}

function update_time($db){
    
    # Get current date
    list($day, $month, $year, $time_speed) = get_ingame_time();
    
    # Compute next date
    $next_day = $day + $time_speed;
    $next_month = $month;
    $next_year = $year;
    if ($next_day > MONTH_DUR[$month-1]){
        $next_day -= MONTH_DUR[$month-1];
        $next_month = $month + 1;
    }
    if ($next_month > 12){
        $next_month = 1;
        $next_year += 1;
    }

    $new_time_str = $next_day."_".$next_month."_".$next_year; 
    
    $upd_time_query = mysqli_prepare($db,
        "UPDATE variables SET value_char = ? WHERE name='time'");
    mysqli_stmt_bind_param($upd_time_query, "s", $new_time_str);
    mysqli_stmt_execute($upd_time_query);
    mysqli_stmt_close($upd_time_query);

}

function lvlup_town_buildings_resources($db){
    
    # For land resources
    $res_query = mysqli_prepare($db,
        'SELECT land_resource_id, time_left FROM land_resources_current_lvlups');
    mysqli_stmt_bind_result($res_query, $res_id, $time_left);
    mysqli_stmt_execute($res_query);
    mysqli_stmt_store_result($res_query);
    while (mysqli_stmt_fetch($res_query)){
        if($time_left==1){  # We need to update this building now
            $res_lvlup_query = mysqli_prepare($db,
                "DELETE FROM land_resources_current_lvlups WHERE land_resource_id=?");
            mysqli_stmt_bind_param($res_lvlup_query, 'i', $res_id);
            mysqli_stmt_execute($res_lvlup_query);
            mysqli_stmt_close($res_lvlup_query);
            
            $lvlup_query = mysqli_prepare($db,
                "UPDATE land_resources SET level = level+1 WHERE id=?");
            mysqli_stmt_bind_param($lvlup_query, 'i', $res_id);
            mysqli_stmt_execute($lvlup_query);
            mysqli_stmt_close($lvlup_query);
            
        } else {
            $upd_res_lvlup_query = mysqli_prepare($db,
                "UPDATE land_resources_current_lvlups SET time_left = time_left - 1 WHERE land_resource_id=?");
            mysqli_stmt_bind_param($upd_res_lvlup_query, 'i', $res_id);
            mysqli_stmt_execute($upd_res_lvlup_query);
            mysqli_stmt_close($upd_res_lvlup_query);
        }
    }
    mysqli_stmt_close($res_query);
    
    ########################################
    # For town buildings
    ########################################
    
    $town_query = mysqli_prepare($db,
        'SELECT town_building_id, time_left FROM town_buildings_current_lvlups');
    mysqli_stmt_bind_result($town_query, $town_building_id, $time_left);
    mysqli_stmt_execute($town_query);
    mysqli_stmt_store_result($town_query);
    
    while (mysqli_stmt_fetch($town_query)){
        if($time_left==1){  # We need to update this building now
            $building_lvlup_query = mysqli_prepare($db,
                "DELETE FROM town_buildings_current_lvlups WHERE town_building_id=?");
            mysqli_stmt_bind_param($building_lvlup_query, 'i', $town_building_id);
            mysqli_stmt_execute($building_lvlup_query);
            mysqli_stmt_close($building_lvlup_query);
            
            $lvlup_query = mysqli_prepare($db,
                "UPDATE town_buildings SET level = level+1 WHERE id=?");
            mysqli_stmt_bind_param($lvlup_query, 'i', $town_building_id);
            mysqli_stmt_execute($lvlup_query);
            mysqli_stmt_close($lvlup_query);
            
        } else {
            $upd_building_lvlup_query = mysqli_prepare($db,
                "UPDATE town_buildings_current_lvlups SET time_left = time_left - 1 WHERE town_building_id=?");
            mysqli_stmt_bind_param($upd_building_lvlup_query, 'i', $town_building_id);
            mysqli_stmt_execute($upd_building_lvlup_query);
            mysqli_stmt_close($upd_building_lvlup_query);
        }
    }
    mysqli_stmt_close($town_query);
    
    
}


function update_towns($db){
    
    update_town_pop($db, DEATH_RATE, BIRTH_RATE, SMALL_TOWN_LIMIT, 
        SMALL_TOWN_BONUS, HAS_PLAYER_BONUS, MIN_POP);
    
    update_town_params($db);
    

}

function update_resources($db){
    update_ready_fields();
}



function pop_to_land_resources($db){
    # TODO THIS REQUIRES FURTHER TESTING AND DEBUGGING (and commenting)
    
    # Delete all previous records of our villagers working at resources
    $reset_jobs_query = mysqli_prepare($db,
                "DELETE FROM land_res_jobs");
    mysqli_stmt_execute($reset_jobs_query);
    mysqli_stmt_close($reset_jobs_query);
    
    # Take all towns and group them by region and ownership creating a 3D matrix
    $town_query = mysqli_prepare($db,
        'SELECT id, population, owner_id, region_id FROM towns ORDER BY region_id, owner_id');
    mysqli_stmt_bind_result($town_query, $town_id, $pop, $owner_id, $region_id);
    mysqli_stmt_execute($town_query);
    mysqli_stmt_store_result($town_query);
    
    $towns = array();
    $first = True;
    $tmp = array();
    $previous_region = -1;
    
    while (mysqli_stmt_fetch($town_query)){
        if ($owner_id == NO_OWNER_ID){
            continue;
        }
        if ($first){
            $first = False;
            $previous_region = $region_id;
        }
        else if ($region_id != $previous_region){
            $towns[$previous_region] = $tmp;
            $previous_region = $region_id;
            $tmp = array();
        }
        if (array_key_exists($owner_id, $tmp)){
            $tmp[$owner_id][] = array($town_id,round($pop));
        }
        else {
            $tmp[$owner_id] = array(array($town_id, round($pop)));
        }
    }
    # Register last entry
    $towns[$previous_region] = $tmp;
            
    mysqli_stmt_close($town_query);
    
    # Get capacity of the buildings from the DB
    $capacity = array();
    $cap_query = mysqli_prepare($db,
        'SELECT resource_id, level, max_capacity FROM land_resources_capacity');
    mysqli_stmt_bind_result($cap_query, $resource_id, $level, $max_capacity);
    mysqli_stmt_execute($cap_query);
    while (mysqli_stmt_fetch($cap_query)){
        $capacity[$resource_id][$level] = $max_capacity;
    }
    
    ###########################################
    # Do the same for the resources, creating a 3D matrix with the resource, region and ownership
    $res_query = mysqli_prepare($db,
        'SELECT id, resource, level, manual_limit, owner_id, region_id FROM land_resources ORDER BY region_id, owner_id');
    mysqli_stmt_bind_result($res_query, $resource_id, $resource_main_id, $level, $manual_limit, $owner_id, $region_id);
    mysqli_stmt_execute($res_query);
    mysqli_stmt_store_result($res_query);
    
    $resources = array();
    $first = True;
    $tmp = array();
    $previous_region = -1;
    
    while (mysqli_stmt_fetch($res_query)){
        if ($owner_id == NO_OWNER_ID){
            continue;
        }
        if ($first){
            $first = False;
            $previous_region = $region_id;
        }
        else if ($region_id != $previous_region){
            $resources[$previous_region] = $tmp;
            $previous_region = $region_id;
            $tmp = array();
        }
        if (array_key_exists($owner_id, $tmp)){
            if (is_null($manual_limit)){
                $tmp[$owner_id][] = array($resource_id, $capacity[$resource_main_id][$level]);
            } else {
                $tmp[$owner_id][] = array($resource_id, $manual_limit);
            }
        }
        else {
            if (is_null($manual_limit)){
                $tmp[$owner_id] = array(array($resource_id, $capacity[$resource_main_id][$level]));
            } else {
                $tmp[$owner_id] = array(array($resource_id, $manual_limit));
            }
        }
    }
    # Register last entry
    $resources[$previous_region] = $tmp;
            
    mysqli_stmt_close($res_query);
    

    # Let's put those villagers to work
    foreach ($resources as $key => $value){
        $act_region = $key;
        $regional_resources = $value;
        foreach ($regional_resources as $owner_id => $user_res){
            # We get all the towns in the same region with the same owner
            if (array_key_exists($act_region, $towns) && array_key_exists($owner_id, $towns[$act_region])) {
                    $selected_towns = $towns[$act_region][$owner_id];
                    $selected_resources = $user_res;
                    # DISTRIBUTE THE WORK
                    distribute_villagers($db, $selected_resources, $selected_towns);
            }
        }
    }
}


function work_resources($db){
    # Get all resources 
    $res_query = mysqli_prepare($db,
        'SELECT id, resource, level, status, owner_id '
            . 'FROM land_resources '
            . 'ORDER BY id');
    mysqli_stmt_bind_result($res_query, $resource_id, $resource_main_id, $level, $status, $owner_id);
    mysqli_stmt_execute($res_query);
    mysqli_stmt_store_result($res_query);
    while (mysqli_stmt_fetch($res_query)){
        # Get how many workers are working there
        $workers_query = mysqli_prepare($db,
            'SELECT SUM(people) '
                . 'FROM land_res_jobs '
                . 'WHERE working_at=?');
        mysqli_stmt_bind_param($workers_query, 'i', $resource_id);
        mysqli_stmt_bind_result($workers_query, $n_workers);
        mysqli_stmt_execute($workers_query);
        mysqli_stmt_fetch($workers_query);
        mysqli_stmt_close($workers_query);

        
        # Produce and add new materials to the warehouse
        if ((int)$n_workers > 0 ){
            $production = produce($db, $resource_id, $resource_main_id, $level, $status, (int)$n_workers);
            if (empty($production)) {
                continue;
            }
            # Get user's pantry and warehouse
            $buildings_query = mysqli_prepare($db,
                'SELECT id, building_id, level '
                    . 'FROM buildings '
                    . 'WHERE owner_id = ? AND (building_id = '.WAREHOUSE_ID.' OR building_id = '.PANTRY_ID.')');
            mysqli_stmt_bind_param($buildings_query, 'i', $owner_id);
            mysqli_stmt_bind_result($buildings_query, $my_building_id, $main_building_id, $level);
            mysqli_stmt_execute($buildings_query);
            while (mysqli_stmt_fetch($buildings_query)){
                if ($main_building_id==WAREHOUSE_ID){
                    $my_warehouse_id = $my_building_id;
                    $my_warehouse_lvl = $level;
                } else {
                    $my_pantry_id = $my_building_id;
                    $my_pantry_lvl = $level;
                }
            }
            mysqli_stmt_close($buildings_query);
            
            foreach ($production as $item_id => $quantity){
                if (in_array($item_id, WAREHOUSE_ITEMS)){
                    add_to_warehouse($owner_id, $my_warehouse_id, $item_id, $quantity);
                } else {  
                    add_to_pantry($owner_id, $my_pantry_id, $item_id, $quantity);
                }
            }
        }
        
    }
    mysqli_stmt_close($res_query);
}

function lvlup_personal_buildings($db){
    
    $current_lvlups_query = mysqli_prepare($db,
        'SELECT user_building_id, time_left FROM buildings_current_lvlups');
    mysqli_stmt_bind_result($current_lvlups_query, $user_building_id, $time_left);
    mysqli_stmt_execute($current_lvlups_query);
    mysqli_stmt_store_result($current_lvlups_query);
    while (mysqli_stmt_fetch($current_lvlups_query)){
        if($time_left==1){  # We need to update this building now
            $del_lvlup_query = mysqli_prepare($db,
                "DELETE FROM buildings_current_lvlups WHERE user_building_id=?");
            mysqli_stmt_bind_param($del_lvlup_query, 'i', $user_building_id);
            mysqli_stmt_execute($del_lvlup_query);
            mysqli_stmt_close($del_lvlup_query);
            
            $lvlup_query = mysqli_prepare($db,
                "UPDATE buildings SET level = level+1 WHERE id=?");
            mysqli_stmt_bind_param($lvlup_query, 'i', $user_building_id);
            mysqli_stmt_execute($lvlup_query);
            mysqli_stmt_close($lvlup_query);
            
        } else {
            $upd_res_lvlup_query = mysqli_prepare($db,
                "UPDATE buildings_current_lvlups SET time_left = time_left - 1 WHERE user_building_id=?");
            mysqli_stmt_bind_param($upd_res_lvlup_query, 'i', $user_building_id);
            mysqli_stmt_execute($upd_res_lvlup_query);
            mysqli_stmt_close($upd_res_lvlup_query);
        }
    }
    mysqli_stmt_close($current_lvlups_query);
    
}
        
function work_internal($db){
    
    # Select all workers
    $workers_query = mysqli_prepare($db,
        'SELECT strength, dexterity, charisma, owner_id, task FROM workers');
    mysqli_stmt_bind_result($workers_query, $strength, $dexterity, $charisma, $owner_id, $task);
    mysqli_stmt_execute($workers_query);
    mysqli_stmt_store_result($workers_query);
    while (mysqli_stmt_fetch($workers_query)){
        work($db, $strength, $dexterity, $charisma, $owner_id, $task);        
    }
    mysqli_stmt_close($workers_query);

    
}

function update_birthdays($db){
    // TODO
    
}

function delete_users($db){
    # Select all workers
    $del_users_query = mysqli_prepare($db,
        'SELECT id, del_countdown FROM users WHERE del_countdown IS NOT NULL');
    mysqli_stmt_bind_result($del_users_query, $user_id, $del_countdown);
    mysqli_stmt_execute($del_users_query);
    mysqli_stmt_store_result($del_users_query);
    while (mysqli_stmt_fetch($del_users_query)){
        if ($del_countdown == 1){
            delete($user_id);
        } else {
            $upd_alert_query = mysqli_prepare($db,
                'UPDATE users SET $del_countdown = $del_countdown - 1 WHERE id = ?');
            mysqli_stmt_bind_param($upd_alert_query, 'i', $user_id);
            mysqli_stmt_execute($upd_alert_query);
            mysqli_stmt_close($upd_alert_query);
        }
    }
    
    mysqli_stmt_close($del_users_query);
}

function delete_inactive($db){
    
    $today = date("Y-m-d H:i:s");
    
    $conn_users_query = mysqli_prepare($db,
        'SELECT user_id, max(date) FROM connections
        GROUP BY user_id');
    mysqli_stmt_bind_result($conn_users_query, $user_id, $my_date);
    mysqli_stmt_execute($conn_users_query);
    while (mysqli_stmt_fetch($conn_users_query)){
        if ($today - $my_date > INACTIVITY_PERIOD){
            delete($user_id);
        }
    }
    
    mysqli_stmt_close($conn_users_query);
    
}

