<?php
session_start(); 
require '../../../../private/db_connect.php';
require '../../../../utils/php/other/verify_user.php';

require "../../../../private/vars/field_animal_vars.php";
require "../../../../private/vars/building_vars.php";

require '../../../../utils/php/building/compute_space.php';
require '../../../../utils/php/animal_management/sacriface.php';



$stable_id = $_POST['stable_id'];
$new_values[CHICKEN_ID] = $_POST['chicken_range'];
$new_values[GOOSE_ID] = $_POST['goose_range'];
$new_values[SHEEP_ID] = $_POST['sheep_range'];
$new_values[PIG_ID] = $_POST['pig_range'];
$new_values[COW_ID] = $_POST['cow_range'];
$new_values[HORSE_ID] = $_POST['horse_range'];
$user_id = $_SESSION['user_id'];


# Check that the stable is, in fact, from the user that clicked the button
$get_id_query = mysqli_prepare($db,
    'SELECT owner_id, level FROM buildings WHERE id = ?');
mysqli_stmt_bind_param($get_id_query, "i", $stable_id);
mysqli_stmt_bind_result($get_id_query, $stable_owner, $stable_level);
mysqli_stmt_execute($get_id_query);
mysqli_stmt_fetch($get_id_query);
mysqli_stmt_close($get_id_query);

if ($stable_owner == $user_id){
    
    # Let's make sure the values add up to 100% or less (adjust otherwise)
    $total_perc = 0;
    $adjust_values = array();
    foreach ($new_values as $key => $value){
        $adjust_value = $value;
        if ($total_perc + $value > 100){
           $adjust_values = 100 - $total_perc;
        }
        $total_perc += $adjust_value;
        $adjust_values[$key] = $adjust_value;
    }
    
    # Get some extra info we might need during the updating proccess.
    ## Get max_cap of the building
    $get_cap_query = mysqli_prepare($db,
        'SELECT max_capacity '
            . 'FROM buildings_capacity '
            . 'WHERE building_id = '.STABLE_ID.' AND level= ?');
    mysqli_stmt_bind_param($get_cap_query, "i", $stable_level);
    mysqli_stmt_bind_result($get_cap_query, $stable_max_cap);
    mysqli_stmt_execute($get_cap_query);
    mysqli_stmt_fetch($get_cap_query);
    mysqli_stmt_close($get_cap_query);

    ## Get the current population of all the animals
    $curr_pop = array();
    
    $get_animal_query = mysqli_prepare($db,
        'SELECT animal_id, pop FROM stables WHERE building_id = ?');
    mysqli_stmt_bind_param($get_animal_query, "i", $stable_id);
    mysqli_stmt_bind_result($get_animal_query, $animal_id, $animal_pop);
    mysqli_stmt_execute($get_animal_query);
    while (mysqli_stmt_fetch($get_animal_query)){
        $curr_pop[$animal_id] = $animal_pop;
    }
    mysqli_stmt_close($get_animal_query);
    
    # Get how much space each animal takes
    $animal_space = array();
    
    $get_space_query = mysqli_prepare($db,
        'SELECT id, space FROM stable_animals_info');
    mysqli_stmt_bind_result($get_space_query, $animal_id, $space);
    mysqli_stmt_execute($get_space_query);
    while (mysqli_stmt_fetch($get_space_query)){
        $animal_space[$animal_id] = $space;
    }
    mysqli_stmt_close($get_space_query);        
            
    # Time to update
    foreach ($adjust_values as $key => $value){
        
        # What would be the maximum pop given this values?
        $max_pop = floor($stable_max_cap * $value / 100 / $animal_space[$key]);
        
        
        # Do we have to reduce the current population? (sacrifice them)
        if ($curr_pop[$key] > $max_pop){
            $diff = $curr_pop[$key] - $max_pop;
            $res = sacrifice_animal($key, $diff, $stable_id, $user_id);
            if ($res == -1){
                header('HTTP/1.1 400 Bad Request error');
                exit;
            }
            $curr_pop = $max_pop;
        }
        
        # Update stable info
        $upd_query = mysqli_prepare($db,
            'UPDATE stables SET pop=? ,max_pop=? WHERE building_id = ? AND animal_id = ?');
        mysqli_stmt_bind_param($upd_query, "iiii", $curr_pop[$key], $max_pop, $stable_id, $key);
        mysqli_stmt_execute($upd_query);
        mysqli_stmt_fetch($upd_query);
        mysqli_stmt_close($upd_query);
        
    }
    
   

    echo json_encode($adjust_values);
    # echo json_encode($res);   # TODO Returning this array would provide valuable info
}