<?php
session_start(); 
require '../../../../private/db_connect.php';
require '../../../../utils/php/other/verify_user.php';
require '../../../../private/vars/land_resources_vars.php';
require '../../../../utils/php/time/compute_turns_left.php';
require '../../../../utils/php/time/get_ingame_time.php';

$resource_id = $_POST['resource_id'];
$new_production = $_POST['new_production'];
$user_id = $_SESSION['user_id'];

# Make sure that $resource_id belongs to the user (never trust user input!)
$ownership_query = mysqli_prepare($db,
    'SELECT owner_id FROM land_resources WHERE id = ?');
mysqli_stmt_bind_param($ownership_query, "i", $resource_id);
mysqli_stmt_bind_result($ownership_query, $res_owner_id);
mysqli_stmt_execute($ownership_query);
mysqli_stmt_fetch($ownership_query);
mysqli_stmt_close($ownership_query);

if ($res_owner_id != $user_id){
    return;
}


#Let's see what date is today
list($day, $month, $year, $time_speed) = get_ingame_time();
$month_names = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre', 'Enero');

# Let's get some info of our new production
$field_info_query = mysqli_prepare($db,
    'SELECT start, end FROM field_resource_info WHERE id=?');
mysqli_stmt_bind_param($field_info_query, "i", $new_production);
mysqli_stmt_bind_result($field_info_query, $start, $end);
mysqli_stmt_execute($field_info_query);
mysqli_stmt_fetch($field_info_query);
mysqli_stmt_close($field_info_query);



# Let's see if the field would be ready on time
if ($new_production==CATTLE_RAISING_ID){
    $prepared=1;
} else {
    if ($month >= $start && $month <= $end){    # If we should aready be harvesting...
        $prepared = 0;
    } else {
        if (($start+12)-$month < NEEDED_TIME_BEFORE_PREPARED OR ($start+12)-$month > 12){ # If we do NOT have enough time to prepare
            $prepared = 0;
        } else  {
            $prepared = 1;
        }
    }
}
# Compute how many turns are left until next the harvest
list($deadline_day, $deadline_month, $deadline_year) = get_deadline($month, $year, $start, $end, $prepared);
$turns_left = compute_turns_left($day, $month, $year, $deadline_day, $deadline_month, $deadline_year, $time_speed);  

$get_role_query = mysqli_prepare($db,
    'UPDATE field_resource SET growing=?, prepared=?  WHERE resource_id=?');
mysqli_stmt_bind_param($get_role_query, "iii", $new_production, $prepared, $resource_id);
mysqli_stmt_execute($get_role_query);
mysqli_stmt_close($get_role_query);


$my_month = $month_names[$deadline_month-1];
echo $new_production.",".$my_month.",".$turns_left; # This is our return function
