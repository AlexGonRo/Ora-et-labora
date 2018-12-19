<?php
session_start(); 
require '../../../../private/db_connect.php';
require '../../../../private/vars/building_vars.php';
require '../../../../private/vars/worker_vars.php';
require '../../../../private/vars/names.php';
require '../../../../utils/php/worker/create_worker.php';
require '../../../../utils/php/building/compute_space.php';



# Make sure we have enough space for the worker
list($occupied, $total_space) = compute_workers_space($db, $_SESSION['user_id']);

if($occupied-$total_space < 0){
    # We need to get the region_id and castle_id before inserting the worker
    $castle_query = mysqli_prepare($db,
      "SELECT id, region_id FROM castles_monasteries WHERE owner_id = ? LIMIT 1");
    mysqli_stmt_bind_param($castle_query, "i", $_SESSION['user_id']);
    mysqli_stmt_bind_result($castle_query, $castle_id, $region_id);
    mysqli_stmt_execute($castle_query);
    mysqli_stmt_fetch($castle_query);
    mysqli_stmt_close($castle_query);  
    
    
    # Hire a new worker
    create_insert_worker(CASTILIAN_NAMES, CASTILIAN_SURNAMES,
        $_SESSION['user_id'], $region_id, $castle_id);
            
    # Get the name of the last inserted worker
    
    $worker_id_query = mysqli_prepare($db,
      "SELECT name FROM workers WHERE owner_id = ? ORDER BY id DESC LIMIT 1");
    mysqli_stmt_bind_param($worker_id_query, "i", $_SESSION['user_id']);
    mysqli_stmt_bind_result($worker_id_query, $my_name);
    mysqli_stmt_execute($worker_id_query);
    mysqli_stmt_fetch($worker_id_query);
    mysqli_stmt_close($worker_id_query);       
            
    echo $my_name;
    return ;
    
} else {
    // TODO Error management missing
    return ;
}

return ; 
