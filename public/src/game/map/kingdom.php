<?php 
session_start(); 
require '../../private/db_connect.php';
require '../../utils/php/other/verify_user.php';
require '../../utils/php/other/render_left_menu.php';
 
# Get kingdom's id
if (!empty($_GET['kingdom_id'])){
    $kingdom_id = $_GET["kingdom_id"];
} else {
    # The default kingdom is the one the user belongs to
    $kingdom_query = mysqli_prepare($db,
        'SELECT kingdom_id '
            . 'FROM users '
            . 'WHERE id=?');
    mysqli_stmt_bind_param($kingdom_query, "i", $_SESSION['user_id']);
    mysqli_stmt_bind_result($kingdom_query, $kingdom_id);
    mysqli_stmt_execute($kingdom_query);
    mysqli_stmt_fetch($kingdom_query);
    mysqli_stmt_close($kingdom_query);
}

# Get kingdom's info
$kingdom_info_query = mysqli_prepare($db,
    'SELECT name '
        . 'FROM kingdoms '
        . 'WHERE id=?');
mysqli_stmt_bind_param($kingdom_info_query, "i", $kingdom_id);
mysqli_stmt_bind_result($kingdom_info_query, $kingdom_name);
mysqli_stmt_execute($kingdom_info_query);
mysqli_stmt_fetch($kingdom_info_query);
mysqli_stmt_close($kingdom_info_query);

# Get a list of all the regions controlled by this kingdom
$regions = array();
$regions_query = mysqli_prepare($db,
    'SELECT id, name '
        . 'FROM regions '
        . 'WHERE kingdom_id=?');
mysqli_stmt_bind_param($regions_query, "i", $kingdom_id);
mysqli_stmt_bind_result($regions_query, $region_id, $region_name);
mysqli_stmt_execute($regions_query);
while (mysqli_stmt_fetch($regions_query)){
    $regions[] = array('id' => $region_id,
        'name' => $region_name);
}
mysqli_stmt_close($regions_query);


require 'tmpl/kingdom.php';
        
        
        