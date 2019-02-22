<?php
session_start(); 
require '../../../../private/db_connect.php';
require '../../../../utils/php/other/verify_user.php';

require '../../../../private/vars/worker_vars.php';
require '../../../../private/vars/registration_vars.php';
require '../../../../private/vars/names.php';
require '../../../../private/vars/land_resources_vars.php';

require '../../../../utils/php/worker/create_worker.php';


# TODO Needs to be checked. It may not work properly anymore.
#       If it does, maybe some queries are unnecessary

# ---------------------------------------
# ---------------------------------------
# ---------------------------------------
# Get all the data we need
$new_town_id = $_POST['town_id'];
$user_id = $_POST['user_id'];

# Get the id of the town the user lives in at the moment
$get_current_town_query = mysqli_prepare($db,
        "SELECT town_id FROM castles_monasteries WHERE owner_id=? LIMIT 1");
mysqli_stmt_bind_param($get_current_town_query, "i", $user_id);
mysqli_stmt_execute($get_current_town_query);
mysqli_stmt_bind_result($get_current_town_query, $current_town);
mysqli_stmt_fetch($get_current_town_query);
mysqli_stmt_close($get_current_town_query);

# ---------------------------------------
# ---------------------------------------
# ---------------------------------------


# Remove french workers
# ---------------------------------------
$rm_workers_query = mysqli_prepare($db,
    'DELETE FROM workers WHERE owner_id = ? ');
mysqli_stmt_bind_param($rm_workers_query, "i", $user_id);
mysqli_stmt_execute($rm_workers_query);
mysqli_stmt_close($rm_workers_query);


# Remove workers(villagers) working on the land resources
# ---------------------------------------

$rm_villager_work_query = mysqli_prepare($db,
    'DELETE FROM land_res_jobs WHERE town_id = ? ');
mysqli_stmt_bind_param($rm_villager_work_query, "i", $current_town);
mysqli_stmt_execute($rm_villager_work_query);
mysqli_stmt_close($rm_villager_work_query);

# Remove related land resources (including field_resource information)
# ---------------------------------------

# Get all the field resources id's associated with the user's town
$field_resources_ids = array();
$get_resources_query = mysqli_prepare($db,
        "SELECT id FROM land_resources WHERE town_id= ? AND resource =".FIELD_RES_ID);
mysqli_stmt_bind_param($get_resources_query, "i", $current_town);
mysqli_stmt_execute($get_resources_query);
mysqli_stmt_bind_result($get_resources_query, $resource_id);
while (mysqli_stmt_fetch($get_resources_query)){
    array_push($field_resources_ids, $resource_id);
}
mysqli_stmt_close($get_resources_query);

#Let's make this so we can use IN statements in prepared querries
$field_resources_qm = implode(',', array_fill(0, count($field_resources_ids), '?'));
$field_resources_types = implode('', array_fill(0, count($field_resources_ids), 'i'));

$rm_land_res_query = mysqli_prepare($db,
    'DELETE FROM field_resource WHERE resource_id IN ('.$field_resources_qm.') ');
mysqli_stmt_bind_param($rm_land_res_query, $field_resources_types, ...$field_resources_ids);
mysqli_stmt_execute($rm_land_res_query);
mysqli_stmt_close($rm_land_res_query);

$rm_land_res_query = mysqli_prepare($db,
    'DELETE FROM land_resources WHERE town_id = ? ');
mysqli_stmt_bind_param($rm_land_res_query, "i", $current_town);
mysqli_stmt_execute($rm_land_res_query);
mysqli_stmt_close($rm_land_res_query);


# ---------------------------------------
# ---------------------------------------
# ---------------------------------------

# Get the name, kingdom and region values of the town
$get_kingdom_query = mysqli_prepare($GLOBALS['db'],
        "SELECT name, kingdom_id, region_id FROM towns WHERE id=?");
mysqli_stmt_bind_param($get_kingdom_query, "i", $new_town_id);
mysqli_stmt_execute($get_kingdom_query);
mysqli_stmt_bind_result($get_kingdom_query, $town_name, $new_kingdom_id, $new_region_id);
mysqli_stmt_fetch($get_kingdom_query);
mysqli_stmt_close($get_kingdom_query);

# Get new town's land resources
$resource_ids = array();
$get_resources_query = mysqli_prepare($GLOBALS['db'],
        "SELECT id FROM land_resources WHERE town_id=?");
mysqli_stmt_bind_param($get_resources_query, "i", $new_town_id);
mysqli_stmt_execute($get_resources_query);
mysqli_stmt_bind_result($get_resources_query, $resource_id);
while (mysqli_stmt_fetch($get_resources_query)){
    array_push($resource_ids, $resource_id);
}
mysqli_stmt_close($get_resources_query);

$resource_ids_qm = implode(',', array_fill(0, count($resource_ids), '?'));
$resource_ids_types = implode('', array_fill(0, count($resource_ids), 'i'));


# Get user's character name
$get_resources_query = mysqli_prepare($GLOBALS['db'],
        "SELECT name FROM characters WHERE belongs_to=?");
mysqli_stmt_bind_param($get_resources_query, "i", $user_id);
mysqli_stmt_execute($get_resources_query);
mysqli_stmt_bind_result($get_resources_query, $char_name);
mysqli_stmt_fetch($get_resources_query);
mysqli_stmt_close($get_resources_query);

# Get user's family name
$get_resources_query = mysqli_prepare($GLOBALS['db'],
        "SELECT username FROM users WHERE id=?");
mysqli_stmt_bind_param($get_resources_query, "i", $user_id);
mysqli_stmt_execute($get_resources_query);
mysqli_stmt_bind_result($get_resources_query, $family_name);
mysqli_stmt_fetch($get_resources_query);
mysqli_stmt_close($get_resources_query);

# Get castle/monastery id
$get_castle_query = mysqli_prepare($GLOBALS['db'],
        "SELECT id FROM castles_monasteries WHERE owner_id=?");
mysqli_stmt_bind_param($get_castle_query, "i", $user_id);
mysqli_stmt_execute($get_castle_query);
mysqli_stmt_bind_result($get_castle_query, $castle_id);
mysqli_stmt_fetch($get_castle_query);
mysqli_stmt_close($get_castle_query);


# Update kingdom in users table
# ---------------------------------------

$update_kingdom_query = mysqli_prepare($db,
    "UPDATE users SET kingdom_id = ? WHERE id=?");
mysqli_stmt_bind_param($update_kingdom_query, "ii", $new_kingdom_id, $user_id);
mysqli_stmt_execute($update_kingdom_query);
mysqli_stmt_close($update_kingdom_query);


# Add new title to character
# ---------------------------------------
// TODO 


# Update hierarchy
# ---------------------------------------
// TODO


# Assign new town 
# ---------------------------------------
$update_town_query = mysqli_prepare($db,
    "UPDATE towns SET owner_id = ? WHERE id=?");
mysqli_stmt_bind_param($update_town_query, "ii", $user_id, $new_town_id);
mysqli_stmt_execute($update_town_query);
mysqli_stmt_close($update_town_query);


# Assign resources from that town
# ---------------------------------------

$update_kingdom_query = mysqli_prepare($db,
    "UPDATE land_resources SET owner_id = ? WHERE id IN (".$resource_ids_qm.")");
#array_unshift($resource_ids, $user_id);
#mysqli_stmt_bind_param($update_kingdom_query, "i".$resource_ids_types, ...$resource_ids);
mysqli_stmt_bind_param($update_kingdom_query, "i".$resource_ids_types, $user_id, ...$resource_ids);
mysqli_stmt_execute($update_kingdom_query);
mysqli_stmt_close($update_kingdom_query);


# Move castle
# ---------------------------------------

$update_castle_query = mysqli_prepare($db,
    "UPDATE castles_monasteries SET region_id = ?, town_id = ? WHERE owner_id=?");
mysqli_stmt_bind_param($update_castle_query, "iii", $new_region_id, $new_town_id , $user_id);
mysqli_stmt_execute($update_castle_query);
mysqli_stmt_close($update_castle_query);

# Move character
# ---------------------------------------
$update_castle_query = mysqli_prepare($db,
    "UPDATE characters SET location_id = ? WHERE belongs_to=?");
mysqli_stmt_bind_param($update_castle_query, "ii", $new_region_id, $user_id);
mysqli_stmt_execute($update_castle_query);
mysqli_stmt_close($update_castle_query);


# Create new workers!
# ---------------------------------------
    
for ( $i = 0; $i < INIT_WORKERS; $i++ ) {

    create_insert_worker(CASTILIAN_NAMES, CASTILIAN_SURNAMES,
        $user_id, $new_region_id, $castle_id);
}

# Finally remove "Villa de los Bienaventurados"
# ---------------------------------------

$rm_town_query = mysqli_prepare($db,
    'DELETE FROM towns WHERE id = ? ');
mysqli_stmt_bind_param($rm_town_query, "i", $current_town);
mysqli_stmt_execute($rm_town_query);
mysqli_stmt_close($rm_town_query);



# Insert alert "You've been moved!"
# ---------------------------------------

# Get in-game time
$get_time_query = mysqli_prepare($GLOBALS['db'],
        "SELECT value_char FROM variables WHERE name='time'");
mysqli_stmt_execute($get_time_query);
mysqli_stmt_bind_result($get_time_query, $ingame_time);
mysqli_stmt_fetch($get_time_query);
mysqli_stmt_close($get_time_query);

# Create alert just for the user!
$alert_text = "¡Te has desplazado a una nueva ubicación!";
$create_alert_query = mysqli_prepare($db,
    "INSERT INTO news(date, text, relevance, affects_to) VALUES(?,?,'private',?)");
mysqli_stmt_bind_param($create_alert_query, "ssi", $ingame_time, $alert_text , $user_id);
mysqli_stmt_execute($create_alert_query);
mysqli_stmt_close($create_alert_query);

# Create alert for everyone in the kingdom

$alert_text = "¡$char_name $family_name se ha establecido en la villa de $town_name!";
$create_alert_query = mysqli_prepare($db,
    "INSERT INTO news(date, text, relevance, kingdom_id) VALUES(?,?,'kingdom',?)");
mysqli_stmt_bind_param($create_alert_query, "ssi", $ingame_time, $alert_text , $new_kingdom_id);
mysqli_stmt_execute($create_alert_query);
mysqli_stmt_close($create_alert_query);

