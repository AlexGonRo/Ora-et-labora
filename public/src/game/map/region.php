<?php 
session_start(); 
require '../../private/db_connect.php';
require '../../utils/php/other/verify_user.php';
require '../../utils/php/land_res/get_res_name.php';
require '../../utils/php/other/render_left_menu.php';


# Get province's id
if (!empty($_GET['id'])){
    $region_id = $_GET["id"];
} else {
    # The default province is the one the user's character is in at the moment
    $char_province_query = mysqli_prepare($db,
        'SELECT location_id '
            . 'FROM characters '
            . 'WHERE belongs_to=? AND death IS NULL');
    mysqli_stmt_bind_param($char_province_query, "i", $_SESSION['user_id']);
    mysqli_stmt_bind_result($char_province_query, $region_id);
    mysqli_stmt_execute($char_province_query);
    mysqli_stmt_fetch($char_province_query);
    mysqli_stmt_close($char_province_query);
}
# Get province's info
$province_query = mysqli_prepare($db,
    'SELECT a.name, a.owner_id, c.username, a.kingdom_id, b.name, '
        . 'a.terrain '
        . 'FROM regions AS a INNER JOIN kingdoms AS b ON a.kingdom_id=b.id '
        . 'INNER JOIN users AS c ON a.owner_id=c.id '
        . 'WHERE a.id=?');
mysqli_stmt_bind_param($province_query, "i", $region_id);
mysqli_stmt_bind_result($province_query, $region_name, 
        $region_owner_id, $region_owner_name, $region_kingdom_id, 
        $region_kingdom_name, $region_terrain);
mysqli_stmt_execute($province_query);
mysqli_stmt_fetch($province_query);
mysqli_stmt_close($province_query);

# Get a list of all the towns of this region (and their owners)

$towns = array();
$towns_query = mysqli_prepare($db,
    'SELECT id, name, owner_id, population '
        . 'FROM towns '
        . 'WHERE region_id=?');
mysqli_stmt_bind_param($towns_query, "i", $region_id);
mysqli_stmt_bind_result($towns_query, $town_id, $town_name, 
        $town_owner_id, $population);
mysqli_stmt_execute($towns_query);
while (mysqli_stmt_fetch($towns_query)){
    $towns[] = array('id' => $town_id, 
        'name' => $town_name,
        'owner_id' => $town_owner_id,
        'pop' => round($population)
    );
}
mysqli_stmt_close($towns_query);

# Get a list of all the resources of the region (and their owners)
$resources = array();
$res_query = mysqli_prepare($db,
    'SELECT a.id, c.name, a.owner_id '
        . 'FROM land_resources AS a INNER JOIN land_resources_names AS c ON c.id=a.resource '
        . 'WHERE a.region_id=?');
mysqli_stmt_bind_param($res_query, "i", $region_id);
mysqli_stmt_bind_result($res_query, $res_id, $res_name, 
        $res_owner_id);
mysqli_stmt_execute($res_query);
while (mysqli_stmt_fetch($res_query)){
    $resources[] = array('id' => $res_id, 
        'name' => get_res_type_name($res_name) ." de ". $region_name,
        'owner_id' => $res_owner_id
    );
}
mysqli_stmt_close($res_query);

# Let's see how many users we have in this region and how many properties they have
$user_num_properties = array();
foreach($towns as $town){
    if(array_key_exists($town['owner_id'], $user_num_properties)){
        $user_num_properties[$town['owner_id']] += 1;
    } else {
        $user_num_properties[$town['owner_id']] = 1;
    }
}
foreach($resources as $res){
    if(array_key_exists($res['owner_id'], $user_num_properties)){
        $user_num_properties[$res['owner_id']] += 1;
    } else {
        $user_num_properties[$res['owner_id']] = 1;
    }
}

$users = array();
// Look for each username in the DB
foreach($user_num_properties as $user_id => $num_props){
    $username_query = mysqli_prepare($db,
    'SELECT username '
        . 'FROM users '
        . 'WHERE id=?');
    mysqli_stmt_bind_param($username_query, "i", $user_id);
    mysqli_stmt_bind_result($username_query, $username);
    mysqli_stmt_execute($username_query);
    mysqli_stmt_fetch($username_query);
    mysqli_stmt_close($username_query);
    
    $users[] = array('id' => $user_id,
        'username' => $username,
        'num_props' => $num_props);
}

require 'tmpl/region.php';