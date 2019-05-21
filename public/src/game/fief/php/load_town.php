<?php
if ($_GET) {
    require '../../private/db_connect.php';
    require_once '../../utils/php/other/verify_user.php';

    require_once '../../private/vars/item_vars.php';
    require_once '../../private/vars/town_building_vars.php';
    
    require_once '../../utils/php/item_management/has_resources.php';
    require_once '../../utils/php/item_management/get_lvlup_res.php';
    require_once '../../utils/php/item_management/get_item_info.php';
    require_once '../../utils/php/names/get_name.php';
    
} else {
    session_start(); 
    require_once '../../../private/db_connect.php';
    require_once '../../../utils/php/other/verify_user.php';
    
    require_once '../../../private/vars/item_vars.php';
    require_once '../../../private/vars/town_building_vars.php';

    require_once '../../../utils/php/item_management/has_resources.php';
    require_once '../../../utils/php/item_management/get_lvlup_res.php';
    require_once '../../../utils/php/item_management/get_item_info.php';
    require_once '../../../utils/php/names/get_name.php';
}



$user_id = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $town_id = $_POST['town_id'];
} else if($_GET){
    $town_id = (int)$_GET['id'];
}

# Get all the info about the town

$town_info_query = mysqli_prepare($db,
    'SELECT name, type, region_id, kingdom_id, population, zeal, security, owner_id, local_tax, duchy_tax, royal_tax '
        . 'FROM towns WHERE id = ?');
mysqli_stmt_bind_param($town_info_query, "i", $town_id);
mysqli_stmt_bind_result($town_info_query, $town_name, $town_type, $region_id, $kingdom_id, $population, $zeal, $security, $owner_id, $local_tax, $duchy_tax, $royal_tax);
mysqli_stmt_execute($town_info_query);
mysqli_stmt_fetch($town_info_query);
mysqli_stmt_close($town_info_query);

$population = round($population);   # Remember that population is not an integer for the DB

# Is it my town?
$my_town = False;
if($user_id == $owner_id){
    $my_town = True;
}

# Get family name of the owner
$owner_name = get_username($user_id);
# Get region's name
$region_name = get_region_name($region_id);

# Get kingdom's name
$kingdom_name_query = mysqli_prepare($db,
    'SELECT kingdoms.name FROM kingdoms INNER JOIN users ON kingdoms.id = users.kingdom_id WHERE users.id=?');
mysqli_stmt_bind_param($kingdom_name_query, "i", $owner_id);
mysqli_stmt_bind_result($kingdom_name_query, $kingdom_name);
mysqli_stmt_execute($kingdom_name_query);
mysqli_stmt_fetch($kingdom_name_query);
mysqli_stmt_close($kingdom_name_query);



    
# Make a list of all the possible town buildings
$town_buildings = array();
$buildings_query = mysqli_prepare($db,
    'SELECT a.id, a.level, a.town_building_id, b.name '
        . 'FROM town_buildings AS a INNER JOIN town_buildings_info AS b ON b.id = a.town_building_id '
        . 'WHERE a.town_id=?');
mysqli_stmt_bind_param($buildings_query, "i", $town_id);
mysqli_stmt_bind_result($buildings_query, $building_id, $building_level, $main_building_id, $building_name);
mysqli_stmt_execute($buildings_query);
mysqli_stmt_store_result($buildings_query);

  
# Get each row of data on each iteration until there are no more rows
while (mysqli_stmt_fetch($buildings_query)) {
    
    # Let's check if the building is under construction
    $under_const_query = mysqli_prepare($db,
        "SELECT * FROM town_buildings_current_lvlups WHERE town_building_id=?");
    mysqli_stmt_bind_param($under_const_query, "i", $building_id);
    mysqli_stmt_execute($under_const_query);
    mysqli_stmt_store_result($under_const_query);
    $under_construction = mysqli_stmt_num_rows($under_const_query);
    mysqli_stmt_close($under_const_query);


    # Get both names and quantities for leveling up the building
    $lvlup_array = get_town_building_lvlup_resources($main_building_id, $building_level);
    $lvlup_names = get_item_names(array_keys($lvlup_array));
    
    # Can we actually level this building up?
    $can_lvlup = has_resources($user_id, $lvlup_array) && !$under_construction;
    
    $town_buildings[] = array('id' => $building_id,
        'level' => $building_level,
        'name' => $building_name,
        'type' => $main_building_id, 
        'under_construction' => $under_construction,
        'lvlup_array' => array_combine($lvlup_names,  array_values($lvlup_array)),
        'can_lvlup' => $can_lvlup
        );
}
    
mysqli_stmt_close($buildings_query);

if ($_GET) {
    require 'tmpl/town_info.php';
} else {
    require '../tmpl/town_info.php';
}
