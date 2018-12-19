<?php
require 'gaussian_sampling.php';
require_once BASE_PATH_PUBLIC.'src/private/vars/worker_vars.php';

function create_insert_worker($names, $surnames, $user_id, $region_id, $castle_id){

    
    // Select the last value from the array.
    $name = $names[array_rand($names)];
    $surname = $surnames[array_rand($surnames)];
    $final_name = $name ." ".$surname;

    // Randomize attributes
    $age = purebell(MIN_WORKER_AGE, MAX_WORKER_AGE, PEAK_WORKER_AGE, SD_WORKER_AGE);
    $strength = rand(MIN_STRENGTH, MAX_STRENGTH);
    $max_str = rand(MIN_MAX_STRENGTH, MAX_MAX_STRENGTH);
    $dexterity = rand(MIN_DEXTERITY, MAX_DEXTERITY);
    $max_dex = rand(MIN_MAX_DEXTERITY, MAX_MAX_DEXTERITY);
    $charisma = rand(MIN_CHARISMA, MAX_CHARISMA);
    $max_char = rand(MIN_MAX_CHARISMA, MAX_MAX_CHARISMA);
    // Save selected values
    $insert_worker_query = mysqli_prepare($GLOBALS['db'],
      "INSERT INTO workers (name, age,strength, max_strength,dexterity,max_dexterity,charisma,max_charisma,owner_id, location_id, work_at)"
        . " VALUES (?,?,?,?,?,?,?,?,?,?,?)");
    mysqli_stmt_bind_param($insert_worker_query, "siiiiiiiiii", $final_name,
              $age, $strength, $max_str, $dexterity, $max_dex, $charisma,
              $max_char, $user_id, $region_id, $castle_id);
    mysqli_stmt_execute($insert_worker_query);
    mysqli_stmt_close($insert_worker_query);
            
}
