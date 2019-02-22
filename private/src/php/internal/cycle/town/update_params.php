<?php



function update_town_params($db){
    $town_query = mysqli_prepare($db,
        'SELECT id, security, zeal FROM towns');
    mysqli_stmt_bind_result($town_query, $town_id, $security, $zeal);
    mysqli_stmt_execute($town_query);
    mysqli_stmt_store_result($town_query);
    
    while (mysqli_stmt_fetch($town_query)){
        // TODO
    
    }
    
    mysqli_stmt_close($town_query);
}