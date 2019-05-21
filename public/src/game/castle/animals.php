<?php 
session_start(); 
require '../../private/db_connect.php';
require '../../utils/php/other/verify_user.php';
require '../../utils/php/other/render_left_menu.php';

require "../../private/vars/item_vars.php";
require "../../private/vars/building_vars.php";
require "../../private/vars/field_animal_vars.php";


// Get animal food quantity (and icon)
$food_query = mysqli_prepare($db,
    'SELECT a.quantity '
        . 'FROM pantries AS a INNER JOIN buildings AS b ON a.building_id=b.id '
        . 'WHERE a.item_id='.BARLEY_ID.' AND b.owner_id=?' );
mysqli_stmt_bind_param($food_query, "i", $_SESSION['user_id']);
mysqli_stmt_bind_result($food_query, $animal_food);
mysqli_stmt_execute($food_query);
mysqli_stmt_store_result($food_query);
mysqli_stmt_fetch($food_query);
if(mysqli_stmt_num_rows($food_query)== 0){
    # User does not have this building, abort.
    $animal_food = 0;
}
mysqli_stmt_close($food_query);

$food_icon_query = mysqli_prepare($db,
    'SELECT img '
        . 'FROM item_info '
        . 'WHERE id='.BARLEY_ID );
+mysqli_stmt_bind_result($food_icon_query, $animal_food_img);
mysqli_stmt_execute($food_icon_query);
mysqli_stmt_fetch($food_icon_query);
mysqli_stmt_close($food_icon_query);


// Check if user has stable and, if so, which id it has
$user_stable_query = mysqli_prepare($db,
    'SELECT id, level FROM buildings WHERE owner_id=? AND building_id='.STABLE_ID);
mysqli_stmt_bind_param($user_stable_query, "i", $_SESSION['user_id']);
mysqli_stmt_bind_result($user_stable_query, $user_stable_id, $stable_level);
mysqli_stmt_execute($user_stable_query);
mysqli_stmt_store_result($user_stable_query);
if(mysqli_stmt_num_rows($user_stable_query)== 0){
    # User does not have this building, abort.
    header('location: ./index.php');
}
mysqli_stmt_fetch($user_stable_query);
mysqli_stmt_close($user_stable_query);

// Get maximum animal space
$max_cap_query = mysqli_prepare($db,
    'SELECT max_capacity FROM buildings_capacity WHERE building_id='.STABLE_ID.' AND '
        . 'level=?');
mysqli_stmt_bind_param($max_cap_query, "i", $stable_level);
mysqli_stmt_bind_result($max_cap_query, $stable_max_capacity);
mysqli_stmt_execute($max_cap_query);
mysqli_stmt_fetch($max_cap_query);
mysqli_stmt_close($max_cap_query);

// Check animals in stable
$animals = array();
$unassigned_space = 100;
$stable_query = mysqli_prepare($db,
    'SELECT a.animal_id, b.name, b.space, a.pop, a.max_pop '
        . 'FROM stables AS a INNER JOIN stable_animals_info AS b ON a.animal_id=b.id '
        . 'WHERE building_id = ?');
mysqli_stmt_bind_param($stable_query, "i", $user_stable_id);
mysqli_stmt_bind_result($stable_query, $animal_id, $animal_name, $animal_space, $cur_pop, $max_pop);
mysqli_stmt_execute($stable_query);
while(mysqli_stmt_fetch($stable_query)){
    
    $max_perc = $max_pop*$animal_space/$stable_max_capacity*100; 
    $cur_perc = $cur_pop*$animal_space/$stable_max_capacity*100;
    $unassigned_space -= $max_perc;
    
    $animals[$animal_id] = array(
        'name' =>$animal_name,
        'cur_pop' => $cur_pop,
        'cur_perc' => $cur_perc,
        'max_perc' => $max_perc
    );
    
}
mysqli_stmt_close($stable_query);


// Get stable production
// TODO

require 'tmpl/animals.php';