<?php 
session_start(); 
require '../../private/db_connect.php';
require '../../utils/php/other/verify_user.php';
require '../../utils/php/other/render_left_menu.php';

require '../../private/vars/building_vars.php';

require '../../utils/php/building/compute_space.php';
require '../../utils/php/worker/available_tasks.php';
require '../../utils/php/other/ui.php';

            
# Get all possible jobs that these workers can perform
$available_tasks = available_tasks($_SESSION['user_id']);

# Get this user's role
$user_info_query = mysqli_prepare($GLOBALS['db'],
    'SELECT role FROM users WHERE id=?');
mysqli_stmt_bind_param($user_info_query, "i", $_SESSION['user_id']);
mysqli_stmt_bind_result($user_info_query, $role);
mysqli_stmt_execute($user_info_query);
mysqli_stmt_fetch($user_info_query);
mysqli_stmt_close($user_info_query);

# Get user's castle region
$castle_query = mysqli_prepare($GLOBALS['db'],
    'SELECT region_id FROM castles_monasteries WHERE owner_id=?');
mysqli_stmt_bind_param($castle_query, "i", $_SESSION['user_id']);
mysqli_stmt_bind_result($castle_query, $castle_location);
mysqli_stmt_execute($castle_query);
mysqli_stmt_fetch($castle_query);
mysqli_stmt_close($castle_query);

# Get all the workers the user has hired
$workers_query = mysqli_prepare($db,
    'SELECT id, name, age, task, strength, dexterity, charisma, location_id FROM workers WHERE owner_id=?');
mysqli_stmt_bind_param($workers_query, "i", $_SESSION['user_id']);
mysqli_stmt_bind_result($workers_query, $worker_id, $worker_name, $age, $task, $strength, $dexterity, $charisma, $location_id);
mysqli_stmt_execute($workers_query);
            
$workers = array();
$travel_workers = array();
while (mysqli_stmt_fetch($workers_query)) {
    if($location_id=$castle_location){
        $workers[] = array('id' => $worker_id,
            'name' => $worker_name,
            'age' => $age,
            'strength' => $strength,
            'str_stars' => get_stars($strength),
            'dexterity' => $dexterity,
            'dex_stars' => get_stars($dexterity),
            'charisma' => $charisma,
            'char_stars' => get_stars($charisma),
            'task' => $task
        );
    } else {
        $travel_workers[] = array('id' => $worker_id,
            'name' => $worker_name,
            'age' => $age,
            'strength' => $strength,
            'str_stars' => get_stars($strength),
            'dexterity' => $dexterity,
            'dex_stars' => get_stars($dexterity),
            'charisma' => $charisma,
            'char_stars' => get_stars($charisma),
            'task' => $task
        );
    }

}
mysqli_stmt_close($workers_query);



# How much free space do we have for new workers?
list($occupied, $total_space) = compute_workers_space($db, $_SESSION['user_id']);


require 'tmpl/workers.php';

