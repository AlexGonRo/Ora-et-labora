<?php
if ($_GET) {
    require '../../private/db_connect.php';
    require_once '../../private/vars/building_vars.php';
    require_once '../../private/vars/item_vars.php';
    require_once '../../private/vars/land_resources_vars.php';
    require_once '../../private/vars/cycle_run_vars.php';
    require_once '../../utils/php/other/verify_user.php';

    require_once '../../utils/php/item_management/has_resources.php';
    require_once '../../utils/php/item_management/get_item_info.php';
    require_once '../../utils/php/item_management/get_lvlup_res.php';
    require_once '../../utils/php/time/get_ingame_time.php';
    require_once '../../utils/php/time/compute_turns_left.php';
    require_once '../../utils/php/names/get_name.php';
    
} else {
    session_start(); 
    require_once '../../../private/db_connect.php';
    require_once '../../../private/vars/building_vars.php';
    require_once '../../../private/vars/item_vars.php';
    require_once '../../../private/vars/land_resources_vars.php';
    require_once '../../../private/vars/cycle_run_vars.php';
    require_once '../../../utils/php/other/verify_user.php';

    require_once '../../../utils/php/item_management/has_resources.php';
    require_once '../../../utils/php/item_management/get_item_info.php';
    require_once '../../../utils/php/item_management/get_lvlup_res.php';
    require_once '../../../utils/php/time/get_ingame_time.php';
    require_once '../../../utils/php/time/compute_turns_left.php';
    require_once '../../../utils/php/names/get_name.php';
}

$user_id = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resource_id = $_POST['id'];
} else if($_GET){
    $resource_id = (int)$_GET['id'];
}
# We need to print a lot of information so...let the queries begin!
# ------------------------------------------------------------------

# Get all the info we can about the resource

$resource_info_query = mysqli_prepare($db,
    'SELECT a.resource, a.region_id, a.level, a.status, a.manual_limit, a.owner_id, a.duchy_tax, a.royal_tax, b.max_capacity '
        . 'FROM land_resources as a INNER JOIN land_resources_capacity as b ON a.resource=b.resource_id AND a.level=b.level '
        . 'WHERE a.id = ?');
mysqli_stmt_bind_param($resource_info_query, "i", $resource_id);
mysqli_stmt_bind_result($resource_info_query, $resource_type, $region_id, $level, $status, $manual_limit, $owner_id, $duchy_tax, $royal_tax, $max_cap);
mysqli_stmt_execute($resource_info_query);
mysqli_stmt_fetch($resource_info_query);
mysqli_stmt_close($resource_info_query);

# Is this our resource?
$my_resource = False;
if($user_id == $owner_id){
    $my_resource = True;
}

# Get family name of the owner
$owner_name = get_username($user_id);
# Get region's name
$region_name = get_region_name($region_id);

# Get kingdom's name
$kingdom_name_query = mysqli_prepare($db,
    'SELECT kingdoms.id, kingdoms.name FROM kingdoms INNER JOIN users ON kingdoms.id = users.kingdom_id '
        . 'WHERE users.id=?');
mysqli_stmt_bind_param($kingdom_name_query, "i", $owner_id);
mysqli_stmt_bind_result($kingdom_name_query, $kingdom_id, $kingdom_name);
mysqli_stmt_execute($kingdom_name_query);
mysqli_stmt_fetch($kingdom_name_query);
mysqli_stmt_close($kingdom_name_query);

# Get how many people is working at the fields
$current_cap_query = mysqli_prepare($db,
    'SELECT SUM(people) as people '
        . 'FROM land_res_jobs '
        . 'WHERE working_at=?');
mysqli_stmt_bind_param($current_cap_query, "i", $resource_id);
mysqli_stmt_bind_result($current_cap_query, $current_cap);
mysqli_stmt_execute($current_cap_query);
mysqli_stmt_fetch($current_cap_query);
mysqli_stmt_close($current_cap_query);

if (is_null($current_cap)){ // No current cap in the query about? That means the value is 0
    $current_cap = 0;
}

# Get who's working at the resource(from which towns or villages they come from)
$workers_from = array();
$pop_workers_query = mysqli_prepare($db,
    'SELECT b.id, b.name, a.people '
        . 'FROM land_res_jobs AS a INNER JOIN towns AS b ON a.town_id=b.id '
        . 'WHERE working_at=?');
mysqli_stmt_bind_param($pop_workers_query, "i", $resource_id);
mysqli_stmt_bind_result($pop_workers_query, $town_id, $town_name, $pop_number);
mysqli_stmt_execute($pop_workers_query);

while (mysqli_stmt_fetch($pop_workers_query)){
    $workers_from[] = array('town_id' => $town_id,
        'town_name' => $town_name,
        'pop' => $pop_number
        );

}
mysqli_stmt_close($pop_workers_query);

# Let's check if the resource is currently under an ampliation
$under_const_query = mysqli_prepare($db,
'SELECT * FROM land_resources_current_lvlups WHERE land_resource_id=?');
mysqli_stmt_bind_param($under_const_query, "i", $resource_id);
mysqli_stmt_execute($under_const_query);
mysqli_stmt_store_result($under_const_query);
$under_construction = mysqli_stmt_num_rows($under_const_query);
mysqli_stmt_close($under_const_query);

# How many resources do we need to level up the resource? Do we have enough?
if (!$under_construction){
    # Get both names and quantities for leveling up the building
    $lvlup_array = get_res_lvlup_resources($resource_type, $level);
    $names = get_item_names(array_keys($lvlup_array));
}

# Get additional information about the resource if it's a field
if ($resource_type==FIELD_RES_ID){
    # What's been grown?
    $growing_query = mysqli_prepare($GLOBALS['db'],
        "SELECT a.ready, b.field_resource, b.start, b.end "
            . "FROM field_resource as a INNER JOIN field_resource_info as b ON a.growing=b.id "
            . "WHERE a.resource_id= ?" );
    mysqli_stmt_bind_param($growing_query, "i", $resource_id);
    mysqli_stmt_bind_result($growing_query, $ready, $field_resource, $start, $end);
    mysqli_stmt_execute($growing_query);
    mysqli_stmt_fetch($growing_query);
    mysqli_stmt_close($growing_query);
    

    #Let's see what date is today
    list($day, $month, $year, $time_speed) = get_ingame_time();
    
    # Compute how many turns are left until the end/start of the harvest
    list($deadline_day, $deadline_month, $deadline_year) = get_deadline($month, $year, $start, $end, $ready);
    $turns_left = compute_turns_left($day, $month, $year, $deadline_day, $deadline_month, $deadline_year, $time_speed);

}

if ($_GET) {
    require 'tmpl/land_info.php';
} else {
    require '../tmpl/land_info.php';
}
