<?php

require '../../../../../public/src/private/db_connect.php';
/* 
 * Creates land resources for each region (and adds them to the database).
 * 
 * All regions with sea connections will have, at least, 2 coast resources.
 * Each region will have 7 resources.
 * Hilly terrains have a 20% chance of having mine_resources.
 * Mountainous terrains have a 35% chance
 * A quarry is much more common than any other mine
 */

set_time_limit(0);

// IMPORTANT TUNNING VARIABLES
$min_coast = 2;
$region_resources = 5;
$sea_id = 1;
$field_id = 1;
$normal_resources = array(1,2,9);
$sea_resources = array(3);
$mine_resources = array(4,5,6,7,8,10);
$normal_weights =  array(34,33,33) ;// Weights for plain terrain with no sea
$normal_sea_weights = array(25,25,25,25);// Weights for plain terrain
$normal_hilly_weights = array(28,26,26,7,2,2,2,2,5); // And so on...
$normal_hilly_sea_weights = array(21,21,21,17,7,2,2,2,2,5);
$normal_mount_weights = array(23,21,21,11,3,3,3,3,7);
$normal_mount_sea_weights = array(18,18,18,11,11,3,3,3,3,7);


$query = "SELECT * FROM regions";
$regions_query = mysqli_query($db, $query);

while ($region = mysqli_fetch_array($regions_query)){
    // If the region is the sea, we skip it
    if ($region['terrain']=='sea'){
        continue;
    }
    // We check if the region has a connection to the sea
    $query = "SELECT * FROM borders WHERE region_1_id = $sea_id AND region_2_id = ".$region['id'];
    $has_sea = mysqli_fetch_array(mysqli_query($db, $query));
    if (is_null($has_sea)){
        $has_sea = false;
    }
    // Let's make a list of all the possible resources we could assign to this province
    $possible_resources = $normal_resources;
    $my_weights = $normal_weights;
    if ($has_sea){
        $possible_resources = array_merge($possible_resources, $sea_resources);
        $my_weights = $normal_sea_weights;
    }
    if ($region['terrain']=='hilly'){
        $possible_resources = array_merge($possible_resources, $mine_resources);
        if ($has_sea){
            $my_weights = $normal_hilly_sea_weights;
        }else{
            $my_weights = $normal_hilly_weights;
        }
    }
    if ($region['terrain']=='mountainous'){
        $possible_resources = array_merge($possible_resources, $mine_resources);
        if ($has_sea){
            $my_weights = $normal_mount_sea_weights;
        }else{
            $my_weights = $normal_mount_weights;
        }
    }
    
    
    # --------------------------------------------------------
    # --------------------------------------------------------
    # --------------------------------------------------------
    # Create resources that are not associated to any town or village
    
    for($i = 0; $i < $region_resources; $i++){
        if ($has_sea && $i < $min_coast){
            // Assign one resource related to the sea
            $query = "INSERT INTO land_resources(`resource`, `region_id`) VALUES ('".$sea_resources[array_rand($sea_resources)]."',".$region['id'].")";
            mysqli_query($db, $query);
        } else {
            $rand_resource = select_random($possible_resources,$my_weights);
            $query = "INSERT INTO land_resources(`resource`, `region_id`) VALUES ('".$rand_resource."',".$region['id'].")";
            mysqli_query($db, $query);
            if ($rand_resource==$field_id){
                # Let's get the ID from the last inserted resource
                $query = "SELECT MAX(id) AS resource_id FROM land_resources";
                $resource_id = mysqli_fetch_assoc(mysqli_query($db, $query))['resource_id'];
                # Let's add information about the field to the other table
                $query = "INSERT INTO field_resource(`resource_id`) VALUES (".$resource_id.")";
                mysqli_query($db, $query);
            }
        }
    }
    
    # --------------------------------------------------------
    # --------------------------------------------------------
    # --------------------------------------------------------
    # Create resources that ARE associated to any town or village

    $query = "SELECT id, type FROM towns WHERE region_id = ".$region['id'];
    $towns_query = mysqli_query($db, $query);

    while ($town = mysqli_fetch_array($towns_query)){
        if ($town['type']==0){
            $rand_resource = select_random($possible_resources,$my_weights);
            $query = "INSERT INTO land_resources(`resource`, `region_id`, `town_id`) VALUES (".$rand_resource.",".$region['id'].",".$town['id'].")";
            mysqli_query($db, $query);
            if ($rand_resource==$field_id){
                # Let's get the ID from the last inserted resource
                $query = "SELECT MAX(id) AS resource_id FROM land_resources";
                $resource_id = mysqli_fetch_assoc(mysqli_query($db, $query))['resource_id'];
                # Let's add information about the field to the other table
                $query = "INSERT INTO field_resource(`resource_id`) VALUES (".$resource_id.")";
                mysqli_query($db, $query);
            }
        } else {
            // INSERT TWO FIELD RESOURCES
                for($i = 0; $i < 2; $i++){
                    $query = "INSERT INTO land_resources(`resource`, `region_id`, `town_id`) VALUES (".$field_id.",".$region['id'].",".$town['id'].")";
                    mysqli_query($db, $query);
                    # Let's get the ID from the last inserted resource
                    $query = "SELECT MAX(id) AS resource_id FROM land_resources";
                    $resource_id = mysqli_fetch_assoc(mysqli_query($db, $query))['resource_id'];
                    # Let's add information about the field to the other table
                    $query = "INSERT INTO field_resource(`resource_id`) VALUES (".$resource_id.")";
                    mysqli_query($db, $query);
                }
        }
    }
    
    
}






echo "Done";

function select_random(array $resources, array $weights){

    $count = count($resources); 
    $i = 0; 
    $n = 0; 
    $num = mt_rand(0, array_sum($weights)); 
    while($i < $count){
        $n += $weights[$i]; 
        if($n >= $num){
            break; 
        }
        $i++; 
    }
    return $resources[$i]; 
}