<?php 
session_start(); 
require '../../private/db_connect.php';
require '../../utils/php/other/verify_user.php';
require '../../utils/php/other/render_left_menu.php';

require "../../private/vars/building_vars.php";
require "../../private/vars/field_animal_vars.php";

require '../../utils/php/time/get_ingame_time.php';
require '../../utils/php/time/format_time.php';

// Does the user have this building?
$user_garden_query = mysqli_prepare($db,
    'SELECT id, level FROM buildings WHERE owner_id=? AND building_id='.GARDEN_ID);
mysqli_stmt_bind_param($user_garden_query, "i", $_SESSION['user_id']);
mysqli_stmt_bind_result($user_garden_query, $user_garden_id, $garden_level);
mysqli_stmt_execute($user_garden_query);
mysqli_stmt_store_result($user_garden_query);
if(mysqli_stmt_num_rows($user_garden_query)== 0){
    # User does not have this building, abort.
    header('location: ./index.php');
}
mysqli_stmt_fetch($user_garden_query);
mysqli_stmt_close($user_garden_query);

// Get in-time game
list($day, $month, $year, $time_speed)  = get_ingame_time();

// Get info about the user fields
$gardens = array();
$field_info_query = mysqli_prepare($db,
    'SELECT a.id, growing, img, effectiveness, ready, picked_up, start, end '
        . 'FROM gardens AS a LEFT JOIN field_resource_info AS b ON a.growing=b.id '
        . 'WHERE building_id=?');
mysqli_stmt_bind_param($field_info_query, "i", $user_garden_id);
mysqli_stmt_bind_result($field_info_query, $field_id, $field_growing,
        $field_growing_img, $field_eff, $field_prep, $field_picked_up, $field_start,
        $field_end);
mysqli_stmt_execute($field_info_query);
mysqli_stmt_store_result($field_info_query);
if(mysqli_stmt_num_rows($field_info_query)== 0){
    # User does not have this building, abort.
    header('location: ./index.php');
}
while(mysqli_stmt_fetch($field_info_query)){
    
    $is_harvest_time = false;
    $start_date = "";
    $end_date = "";
    
    if ($field_growing != 0){       # If we are actually growing something
        # Is it harvest time?
        $is_harvest_time = is_harvest_time($month, $start, $end, $field_prep);
        # Give a better text encode to the start-end dates
        $harvest_year = $year;
        if (!$ready){
            $harvest_year += 1;
        }
        $start_date = format_time(1, $field_start, $harvest_year);
        $end_date = format_time(1, $field_end, $harvest_year);   
    }
    
    # What are we doing not with this field?
    $field_mode = "Sin plantar";
    if($field_growing && $is_harvest_time){
        $field_mode = "Listo para la recogida";
    } else if($field_growing && !$is_harvest_time){
        $field_mode = "Cultivando";
    }
    
    $gardens[$field_id] = array(
        'growing' => $field_growing,
        'img' => $field_growing_img,
        'mode' => $field_mode,
        'eff' => $field_eff, 
        'prep' => $field_prep, 
        'picked_up' => $field_picked_up,
        'start' => $start_date,
        'end' => $end_date,
        'is_harvest_time' => $is_harvest_time
    );
    
}
mysqli_stmt_close($field_info_query);

# Get a list of all the available garden seeds
$seeds = array();
$seeds_query = mysqli_prepare($db,
    'SELECT id, field_resource, img, start, end, max_garden '
        . 'FROM field_resource_info '
        . 'WHERE max_garden IS NOT NULL');
mysqli_stmt_bind_result($seeds_query, $seed_id, $seed_name, $seed_img, $seed_start, $seed_end, $seed_max_garden);
mysqli_stmt_execute($seeds_query);

while(mysqli_stmt_fetch($seeds_query)){
    $seeds[$seed_id] = array(
        'name' => $seed_name, 
        'img' => $seed_img, 
        'start' => $seed_start, 
        'end' => $seed_end,
        'max_garden' => $seed_max_garden
    );
}
mysqli_stmt_close($seeds_query);



require 'tmpl/garden.php';