<?php
/* 
 * Scripts for the landing page
 */
        
require BASE_PATH_PUBLIC.'src/utils/php/time/get_ingame_time.php';


function get_news($my_session, $db) {
    
    
    // Let's get this user's region id
    $region_query = mysqli_prepare($db,
        'SELECT a.id '
            . 'FROM regions AS a INNER JOIN castles_monasteries AS b ON a.id = b.region_id '
            . 'WHERE b.owner_id=?');
    mysqli_stmt_bind_param($region_query, "i", $my_session['user_id']);
    mysqli_stmt_bind_result($region_query, $region_id);
    mysqli_stmt_execute($region_query);
    mysqli_stmt_fetch($region_query);
    mysqli_stmt_close($region_query);
 
    // Let's get this user's kingdom id
    $kingdom_query = mysqli_prepare($db,
        'SELECT kingdom_id '
            . 'FROM users '
            . 'WHERE id=?');
    mysqli_stmt_bind_param($kingdom_query, "i", $my_session['user_id']);
    mysqli_stmt_bind_result($kingdom_query, $kingdom_id);
    mysqli_stmt_execute($kingdom_query);
    mysqli_stmt_fetch($kingdom_query);
    mysqli_stmt_close($kingdom_query);
    

    // Let's get this user's private news
    $news_query_text =  "(SELECT date, text FROM news WHERE affects_to=? ORDER BY id)"
            . " union "
            . "(SELECT date, text FROM news WHERE relevance='local' AND region_id=? ORDER BY id)" // User's region news
            . " union "
            . "(SELECT date, text FROM news WHERE relevance='kingdom' AND kingdom_id=? ORDER BY id)" // User's kingdom news
            . " union "
            . "(SELECT date, text FROM news WHERE relevance='global' ORDER BY id)"; // Global kingdom news
    
    $news_query = mysqli_prepare($db,
        $news_query_text);
    mysqli_stmt_bind_param($news_query, "iii", $resource_id, $region_id, $kingdom_id);
    mysqli_stmt_bind_result($news_query, $date, $text);
    mysqli_stmt_execute($news_query);
    
    
    // Let's make the results an array and fix the date
    $news_array = array();
    while(mysqli_stmt_fetch($news_query)){
        list($d,$m,$y) = explode('_', $date);
        $news_array[] = array('day' => $d,'month' => $m,'year' => $y,'msg' => $text);
    }
    
    mysqli_stmt_close($news_query);

    // Let's sort all these news by date
    foreach ($news_array as $key => $row) {
        $day[$key] = $row['day'];
        $month[$key] = $row['month'];
        $year[$key] = $row['year'];
    }
    array_multisort($year, SORT_DESC,$month,SORT_DESC,$day,SORT_DESC,$news_array);
    
    return $news_array;
    
}


function get_alerts($my_session, $db){
    $alerts = array();
    // TODO CHANGE ALL THESE PREDEFINED MESSAGES

    // Check if all workers have a task
    $lazy_worker_query = mysqli_prepare($db,
        "SELECT task FROM workers WHERE owner_id=? AND (task IS NULL OR task='ninguna')");
    mysqli_stmt_bind_param($lazy_worker_query, "i", $my_session['user_id']);
    mysqli_stmt_execute($lazy_worker_query);
    mysqli_stmt_store_result($lazy_worker_query);    

    if ( mysqli_stmt_num_rows($lazy_worker_query)){
        $alerts[] = array('msg' => "Algunos de tus trabajadores no tienen una función asignada");
    }
    mysqli_stmt_close($lazy_worker_query);

    return $alerts;
}

function get_active_actions($my_session, $db){
    $active_actions = array();
    
    //Get the current date
    list($day, $month, $year, $time_speed) = get_ingame_time();
    $month_names = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre', 'Enero');

    ########################################
    // Check if any buildings are been updated
    $buildings_construction_query = mysqli_prepare($db,
        'SELECT time_left, name '
            . 'FROM buildings_current_lvlups INNER JOIN buildings ON buildings.id = buildings_current_lvlups.user_building_id INNER JOIN building_names ON building_names.id = buildings.building_id '
            . 'WHERE owner_id=?');
    mysqli_stmt_bind_param($buildings_construction_query, "i", $my_session['user_id']);
    mysqli_stmt_bind_result($buildings_construction_query, $time_left, $building_name);
    mysqli_stmt_execute($buildings_construction_query);
    
    while (mysqli_stmt_fetch($buildings_construction_query)){
        $active_actions[] = array('msg' => "El edificio ".$building_name." se está"
            . " ampliando (Quedan ".$time_left." turnos)");
    }
    mysqli_stmt_close($buildings_construction_query);

    // Check if there are any any town buildings been updated
    $town_buildings_construction_query = mysqli_prepare($db,
        "SELECT time_left, d.name as town_name, c.name as building_name "
            . "FROM town_buildings_current_lvlups as a INNER JOIN town_buildings as b ON b.id = a.town_building_id "
            . "INNER JOIN town_building_names as c ON c.id = b.town_building_id "
            . "INNER JOIN towns as d ON d.id=b.town_id WHERE owner_id=?");
    mysqli_stmt_bind_param($town_buildings_construction_query, "i", $my_session['user_id']);
    mysqli_stmt_bind_result($town_buildings_construction_query, $time_left, $town_name, $building_name);
    mysqli_stmt_execute($town_buildings_construction_query);
    
    while (mysqli_stmt_fetch($town_buildings_construction_query)){
        $active_actions[] = array('msg' => "El edificio ".$building_name." en "
            .$town_name." se está ampliando (Quedan ".$time_left." turnos)");
    }
    mysqli_stmt_close($town_buildings_construction_query);

        
    // Check if we are updating any land resource
    $res_construction_query = mysqli_prepare($db,
        "SELECT time_left, d.name as region_name, c.name as res_name "
        . "FROM land_resources_current_lvlups as a INNER JOIN land_resources as b ON b.id = a.land_resource_id "
        . "INNER JOIN land_resources_names as c ON c.id = b.resource "
        . "INNER JOIN regions as d ON d.id=b.region_id WHERE b.owner_id=?");
    mysqli_stmt_bind_param($res_construction_query, "i", $my_session['user_id']);
    mysqli_stmt_bind_result($res_construction_query, $time_left, $region_name, $res_name);
    mysqli_stmt_execute($res_construction_query);
    
    while (mysqli_stmt_fetch($res_construction_query)){
         $active_actions[] = array('msg' => "El recurso ".$res_name." en "
             .$region_name." se está ampliando (Quedan ".$time_left." turnos)");
    }
    mysqli_stmt_close($res_construction_query);
    
    // Inform if any land field is close to harvesting seasson or it's been harvested now
    $harvest_query = mysqli_prepare($db,
        "SELECT b.start, b.end, b.field_resource, d.name "
            . "FROM field_resource as a INNER JOIN field_resource_info as b ON a.growing=b.id INNER JOIN land_resources as c ON a.resource_id=c.id INNER JOIN regions as d ON c.region_id=d.id "
            . "WHERE c.owner_id=? AND NOT b.field_resource='cattle_raising' AND a.prepared=TRUE");
    mysqli_stmt_bind_param($harvest_query, "i", $my_session['user_id']);
    mysqli_stmt_bind_result($harvest_query, $start, $end, $field_resource, $region_name);
    mysqli_stmt_execute($harvest_query);
    
    while (mysqli_stmt_fetch($harvest_query)){
        if(($month<$start && ($month + 2) >= $start) || 
                ($month + 2) >= ($start + 12)){
            $active_actions[] = array('msg' => "Quedan poco hasta la recogida de "
                . "".$field_resource." en ".$region_name." (Empieza en ".$month_names[$start-1].")");
        }
        else if(($month > $start) && ($month < $end)){   // TODO This formula gives problems if harvest seasson happens in months such as december
            $active_actions[] = array('msg' => "Estamos recogiendo ".$field_resource
                    ." en ".$region_name." hasta ".$month_names[$end].".");
        }
        
    }
    mysqli_stmt_close($harvest_query);
    

    return $active_actions;
}
