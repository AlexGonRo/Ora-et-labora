<?php


function get_travel_time(){
    
}

/**
 * Given two regions, compute the shortest path between them.
 * 
 * Uses the A* algorithm.
 * 
 * @param int $region_1_id
 * @param int $region_2_id
 * @param array(int) List of regions that make up the route (includes start and finish nodes)
 */
function get_route($region_1_id, $region_2_id){
    
    get_connection_graph();
}

function get_connection_graph(){
    
    $connection_query = mysqli_prepare($db,
        "SELECT region_id "
            . "FROM borders "
            . "WHERE a.owner_id= ? ");

    mysqli_stmt_bind_param($connection_query, "i", $_SESSION['user_id']);
    mysqli_stmt_bind_result($connection_query, $buyer_region_id);
    mysqli_stmt_execute($connection_query);
    mysqli_stmt_fetch($connection_query);
    mysqli_stmt_close($connection_query);
    
    return ;
}