<?php

require BASE_PATH_PUBLIC.'src/private/vars/land_resources_vars.php';
require BASE_PATH_PUBLIC.'src/private/vars/town_vars.php';
require BASE_PATH_PUBLIC.'src/private/vars/town_building_vars.php';
require BASE_PATH_PUBLIC.'src/private/vars/building_vars.php';


function delete_user($user_id){
    # TODO Needs to be checked. It may not work properly anymore.
    #       If it does, maybe some queries are unnecessary
    # ---------------------------------
    #--------------------------------
    # GET ALL THE IMPORTANT INFO WE'LL NEED LATER ON
    #--------------------------------
    # ---------------------------------

    # Get this user's towns
    $town_ids = array();
    $get_towns_query = mysqli_prepare($GLOBALS['db'],
            "SELECT id FROM towns WHERE owner_id= ?");
    mysqli_stmt_bind_param($get_towns_query, "i", $user_id);
    mysqli_stmt_execute($get_towns_query);
    mysqli_stmt_bind_result($get_towns_query, $town_id);
    while (mysqli_stmt_fetch($get_towns_query)){
        array_push($town_ids, $town_id);
    }
    $towns_qm = implode(',', array_fill(0, count($town_ids), '?'));
    $town_types = implode('', array_fill(0, count($town_ids), 'i'));


    # Get this user's land resources
    $field_resources_ids = array();
    $land_resources_ids = array();
    $get_resources_query = mysqli_prepare($GLOBALS['db'],
            "SELECT id, resource FROM land_resources WHERE owner_id= ?");
    mysqli_stmt_bind_param($get_resources_query, "i", $user_id);
    mysqli_stmt_execute($get_resources_query);
    mysqli_stmt_bind_result($get_resources_query, $resource_id, $resource_type);
    while (mysqli_stmt_fetch($get_resources_query)){
        array_push($land_resources_ids, $resource_id);
        if ($resource_type == FIELD_RES_ID){
            array_push($field_resources_ids, $resource_id);
        }
    }
    mysqli_stmt_close($get_resources_query);


    $land_resources_qm = implode(',', array_fill(0, count($land_resources_ids), '?'));
    $land_resources_types = implode('', array_fill(0, count($land_resources_ids), 'i'));
    $field_resources_qm = implode(',', array_fill(0, count($field_resources_ids), '?'));
    $field_resources_types = implode('', array_fill(0, count($field_resources_ids), 'i'));

    # Get this user's pantries and warehouses ids
    $pantry_ids = array();
    $warehouse_ids = array();
    $buildings_id = array();

    $get_pw_ids_query = mysqli_prepare($GLOBALS['db'],
            "SELECT id, building_id "
            . "FROM buildings WHERE owner_id= ? AND (building_id = ".PANTRY_ID." OR building_id = ".WAREHOUSE_ID.")");
    mysqli_stmt_bind_param($get_pw_ids_query, "i", $user_id);
    mysqli_stmt_execute($get_pw_ids_query);
    mysqli_stmt_bind_result($get_pw_ids_query, $building_id, $building_type);
    while (mysqli_stmt_fetch($get_pw_ids_query)){
        array_push($buildings_id, $building_id);
        if ($building_type == PANTRY_ID){
            array_push($pantry_ids, $building_id);
        } else {
            array_push($warehouse_ids, $building_id);
        }
    }

    $building_qm = implode(',', array_fill(0, count($buildings_id), '?'));
    $building_types = implode('', array_fill(0, count($buildings_id), 'i'));
    $pantry_qm = implode(',', array_fill(0, count($pantry_ids), '?'));
    $pantry_types = implode('', array_fill(0, count($pantry_ids), 'i'));
    $warehouse_qm = implode(',', array_fill(0, count($warehouse_ids), '?'));
    $warehouse_types = implode('', array_fill(0, count($warehouse_ids), 'i'));



    # ---------------------------------
    #--------------------------------
    # TOWNS AND LAND RESOURCES INFO
    #--------------------------------
    # ---------------------------------


    # Reset field_resource info
    # --------------------------
    $reset_field_query = mysqli_prepare($db,
        'UPDATE field_resource AS a INNER JOIN land_resources AS b ON a.resource_id = b.id '
            . 'SET a.growing = '.DEFAULT_FIELD_RESOURCE_GROWING.', a.ready = '.DEFAULT_FIELD_RESOURCE_READY.' '
            . 'WHERE b.owner_id = ?');
    mysqli_stmt_bind_param($reset_field_query, "i", $user_id);
    mysqli_stmt_execute($reset_field_query);
    mysqli_stmt_close($reset_field_query);

    # Delete all affected villages working at an abandoned resource
    # --------------------------

    $rm_land_workers_query = mysqli_prepare($db,
        'DELETE FROM land_res_jobs WHERE working_at IN ('.$land_resources_qm.')');
    mysqli_stmt_bind_param($land_resources_ids, $land_resources_types, ...$land_resources_ids);
    mysqli_stmt_execute($rm_land_workers_query);
    mysqli_stmt_close($rm_land_workers_query);

    # Reset land_resources lvls and set them with no owner
    # --------------------------
    $reset_resource_query = mysqli_prepare($db,
        'UPDATE land_resources '
            . 'SET level = '.DEFAULT_LAND_RESOURCE_LVL.', status='.DEFAULT_LAND_RESOURCE_STATUS.', manual_limit = '.DEFAULT_LAND_RESOURCE_MANUAL_LIMIT.' '
            . 'WHERE IN('.$land_resources_qm.')');
    mysqli_stmt_bind_param($reset_resource_query, $land_resources_types, ...$land_resources_ids);
    mysqli_stmt_execute($reset_resource_query);
    mysqli_stmt_close($reset_resource_query);


    # Remove any land_resources lvlups in progress
    # --------------------------
    $rm_resource_lvlup_query = mysqli_prepare($db,
        'DELETE FROM land_resources_current_lvlups WHERE land_resource_id  IN ('.$land_resources_qm.')');
    mysqli_stmt_bind_param($rm_resource_lvlup_query, $land_resources_types, ...$land_resources_ids );
    mysqli_stmt_execute($rm_resource_lvlup_query);
    mysqli_stmt_close($rm_resource_lvlup_query);

    # Delete any town buildings
    # ---------------------------------
    $rm_town_buildings_query = mysqli_prepare($db,
        'UPDATE town_buildings SET lvl=?, preservation=? WHERE town_id  IN ('.$towns_qm.')');
    mysqli_stmt_bind_param($rm_town_buildings_query, "ii".$town_types, 
            DEFAULT_TOWN_BUILDING_LEVEL, DEFAULT_PRESERVATION, ...$town_ids );
    mysqli_stmt_execute($rm_town_buildings_query);
    mysqli_stmt_close($rm_town_buildings_query);

    # Delete any town building lvlup
    # --------------------------
    $rm_town_buildings_lvlups_query = mysqli_prepare($db,
        'DELETE FROM town_buildings_current_lvlups AS aINNER JOIN town_buildings AS b ON a.town_building_id=b.id WHERE b.town_id IN ('.$towns_qm.')');
    mysqli_stmt_bind_param($rm_town_buildings_lvlups_query, $town_types, 
            ...$town_ids );
    mysqli_stmt_execute($rm_town_buildings_lvlups_query);
    mysqli_stmt_close($rm_town_buildings_lvlups_query);


    # Reset town and set it to no owner
    # --------------------------------
    $reset_town_query = mysqli_prepare($db,
        'UPDATE towns '
            . 'SET population = '.DEFAULT_POPULATION.', zeal='.DEFAULT_ZEAL.', secutiry = '.DEFAULT_SECURITY.', '
            . 'owner_id = '.DEFAULT_OWNER_ID.', local_tax = '.DEFAULT_LOCAL_TAX.' '
            . 'WHERE owner_id=?');
    mysqli_stmt_bind_param($reset_town_query, "iiiiisi", $user_id);
    mysqli_stmt_execute($reset_town_query);
    mysqli_stmt_close($reset_town_query);



    # ---------------------------------
    #--------------------------------
    # BUILDINGS AND PRODUCTION INFO
    #--------------------------------
    # ---------------------------------


    # Delete item production queue (user_prod)
    # --------------------------
    $rm_item_prod_query = mysqli_prepare($db,
        'DELETE FROM user_prod WHERE owner_id = ?');
    mysqli_stmt_bind_param($rm_item_prod_query, $user_id);
    mysqli_stmt_execute($rm_item_prod_query);
    mysqli_stmt_close($rm_item_prod_query);


    # Delete pantry items
    # --------------------------
    $rm_pantry_query = mysqli_prepare($db,
        'DELETE FROM pantries WHERE building_id IN ('.$pantry_qm.')');
    mysqli_stmt_bind_param($rm_pantry_query, $pantry_types , ...$pantry_ids);
    mysqli_stmt_execute($rm_pantry_query);
    mysqli_stmt_close($rm_pantry_query);

    # Delete warehouse items
    # --------------------------
    $rm_warehouse_query = mysqli_prepare($db,
        'DELETE FROM warehouses WHERE building_id IN ('.$warehouse_qm.')');
    mysqli_stmt_bind_param($rm_warehouse_query, $warehouse_types , ...$warehouse_ids);
    mysqli_stmt_execute($rm_warehouse_query);
    mysqli_stmt_close($rm_warehouse_query);

    # Delete buildings current lvlups
    # --------------------------
    $rm_b_lvlups_query = mysqli_prepare($db,
        'DELETE FROM buildings_current_lvlups WHERE user_building_id IN ('.$building_qm.')');
    mysqli_stmt_bind_param($rm_b_lvlups_query, $building_types , ...$building_ids);
    mysqli_stmt_execute($rm_b_lvlups_query);
    mysqli_stmt_close($rm_b_lvlups_query);


    # Delete buildings
    # --------------------------
    $rm_buildings_query = mysqli_prepare($db,
        'DELETE FROM buildings WHERE owner_id = ?');
    mysqli_stmt_bind_param($rm_buildings_query, 'i' , $user_id);
    mysqli_stmt_execute($rm_buildings_query);
    mysqli_stmt_close($rm_buildings_query);


    # ---------------------------------
    # ---------------------------------
    # DELETE OTHER INFORMATION
    # ---------------------------------
    # ---------------------------------

    # Take care of the hierarchy
    # --------------------------

    // TODO

    # Delete workers
    # --------------------------
    $rm_workers_query = mysqli_prepare($db,
        'DELETE FROM workers WHERE owner_id = ?');
    mysqli_stmt_bind_param($rm_workers_query, 'i' , $user_id);
    mysqli_stmt_execute($rm_workers_query);
    mysqli_stmt_close($rm_workers_query);


    # Delete characters
    # --------------------------
    $rm_char_query = mysqli_prepare($db,
        'DELETE FROM characters WHERE belongs_to = ?');
    mysqli_stmt_bind_param($rm_char_query, 'i' , $user_id);
    mysqli_stmt_execute($rm_char_query);
    mysqli_stmt_close($rm_char_query);


    # Delete connections
    # --------------------------
    $rm_conn_query = mysqli_prepare($db,
        'DELETE FROM connections WHERE user_id = ?');
    mysqli_stmt_bind_param($rm_conn_query, 'i' , $user_id);
    mysqli_stmt_execute($rm_conn_query);
    mysqli_stmt_close($rm_conn_query);

    # Delete castles/monasteries
    # --------------------------
    $rm_castle_query = mysqli_prepare($db,
        'DELETE FROM castles_monasteries WHERE owner_id = ?');
    mysqli_stmt_bind_param($rm_castle_query, 'i' , $user_id);
    mysqli_stmt_execute($rm_castle_query);
    mysqli_stmt_close($rm_castle_query);


    # Remove private messages
    # --------------------------

    $rm_pm_query = mysqli_prepare($db,
        'DELETE FROM pm WHERE user1 = ? OR user2 = ?');
    mysqli_stmt_bind_param($rm_pm_query, 'ii' , $user_id, $user_id);
    mysqli_stmt_execute($rm_pm_query);
    mysqli_stmt_close($rm_pm_query);


    # Delete user's table
    # --------------------------

    $rm_user_query = mysqli_prepare($db,
        'DELETE FROM users WHERE id = ?');
    mysqli_stmt_bind_param($rm_user_query, 'i' , $user_id);
    mysqli_stmt_execute($rm_user_query);
    mysqli_stmt_close($rm_user_query);

}