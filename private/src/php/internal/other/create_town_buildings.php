<?php
require '../../../../../public/src/private/db_connect.php';
require '../../../../../public/src/private/vars/town_building_vars.php';

$towns_query = mysqli_prepare($db,
    "SELECT a.id, b.type FROM towns AS a LEFT JOIN borders AS b ON a.region_id=b.region_1_id GROUP BY a.region_id, b.type");

mysqli_stmt_bind_result($towns_query, $town_id, $border_type);
mysqli_stmt_execute($towns_query);
mysqli_stmt_store_result($towns_query);


while (mysqli_stmt_fetch($towns_query)) {
    
    if($border_type == 'coast'){
        $insert_buildings_query = mysqli_prepare($GLOBALS['db'],
            "INSERT INTO town_buildings (town_id, town_building_id) VALUES (?,".TOWN_PORT_ID.")");
        mysqli_stmt_bind_param($insert_buildings_query, "i", $town_id);
        mysqli_stmt_execute($insert_buildings_query);
        mysqli_stmt_close($insert_buildings_query);
    } else {
        $insert_buildings_query = mysqli_prepare($GLOBALS['db'],
            "INSERT INTO town_buildings (town_id, town_building_id) "
                . "VALUES (?,".TOWN_WALL_ID."), (?,".TOWN_INFRASTRUCTURE_ID."), (?,".TOWN_MARKET_ID.")");
        mysqli_stmt_bind_param($insert_buildings_query, "iii", $town_id, $town_id, $town_id);
        mysqli_stmt_execute($insert_buildings_query);
        mysqli_stmt_close($insert_buildings_query);
    }
    
}

mysqli_stmt_close($towns_query);