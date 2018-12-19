<?php 
session_start(); 
require '../../private/db_connect.php';
require '../../utils/php/other/verify_user.php';
require '../../utils/php/other/render_left_menu.php';

require '../../private/vars/building_vars.php';
require '../../utils/php/building/compute_space.php';
require '../../utils/php/worker/available_tasks.php';


            
# Get all possible jobs that these workers can perform
$available_tasks = available_tasks($_SESSION['user_id']);

# Get all the workers the user has hired
$workers_query = mysqli_prepare($db,
    'SELECT id, name, age, task, strength, dexterity, charisma, location_id FROM workers WHERE owner_id=?');
mysqli_stmt_bind_param($workers_query, "i", $_SESSION['user_id']);
mysqli_stmt_bind_result($workers_query, $worker_id, $worker_name, $age, $task, $strength, $dexterity, $charisma, $location_id);
mysqli_stmt_execute($workers_query);
            
$workers = array();
while (mysqli_stmt_fetch($workers_query)) {
    $workers[] = array('id' => $worker_id,
        'name' => $worker_name,
        'age' => $age,
        'strength' => $strength,
        'dexterity' => $dexterity,
        'charisma' => $charisma,
        'task' => $task
    );

}
mysqli_stmt_close($workers_query);


# How much free space do we have for new workers?
list($occupied, $total_space) = compute_workers_space($db, $_SESSION['user_id']);


require 'tmpl/workers.php';

