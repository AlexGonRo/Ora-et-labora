<?php

function distribute_villagers($db, $resources_info, $towns_info){
    
    $tmp_resources_info = $resources_info;
    $tmp_towns_info = $towns_info;
    $changes = array(); // Stores the total number of workers we'll assign to a town
    foreach ($resources_info as $key => $res_info){
        $res_id = $res_info[0];
        $changes[$res_id] = array();
        foreach ($towns_info as $key => $town_info){
            $town_id = $town_info[0];
            $changes[$res_id][$town_id] = 0;
        }
    }
    $finished = False;
    
    // Variables so we don't get stuck into an infinite loop
    $counter = 0;
    $counter_limit = 20;
    
    do {
        
        $total_cap = 0;
        $smallest_cap = PHP_INT_MAX;
        $smallest_cap_id = 0;
        $smallest_cap_res_id = 0;
        foreach ($tmp_resources_info as $key => $res_info){
            $res_id = $res_info[0];
            $res_cap = $res_info[1];
            $total_cap += $res_cap;
            if ($res_cap < $smallest_cap){
                $smallest_cap = $res_cap;
                $smallest_cap_id = $key;
                $smallest_cap_res_id = $res_id;
            }
        }

        $total_pop = 0;
        $smallest_pop = PHP_INT_MAX;
        $smallest_pop_id = 0;
        foreach ($tmp_towns_info as $key => $town_info){
            $town_id = $town_info[0];
            $town_pop = $town_info[1];
            $total_pop += $town_pop;
            if ($town_pop < $smallest_pop){
                $smallest_pop = $town_pop;
                $smallest_pop_id = $key;
            }
        }
        
        if (sizeof($tmp_resources_info) == 0 || sizeof($tmp_towns_info) == 0){
            $finished = True;
            continue;
        }

        if(($total_cap/sizeof($tmp_towns_info)) > $smallest_pop){
            
            if ($smallest_cap <= $smallest_pop*sizeof($tmp_towns_info)){    // If there is a resource that would overfill when employing $smallest_pop from every town
                $rest = $smallest_cap%sizeof($tmp_towns_info);
                $to_add = $smallest_cap/sizeof($tmp_towns_info);
                
                foreach ($tmp_towns_info as $key => $town_info){
                    $town_id = $town_info[0];
                    if ($rest){
                        $changes[$smallest_cap_res_id][$town_id] +=  $to_add + 1;
                        $tmp_towns_info[$key][1] -= $to_add + 1;
                        if ($tmp_towns_info[$key][1] == 0){
                            unset($tmp_towns_info[$key]);
                        }
                    } else {
                        $changes[$smallest_cap_res_id][$town_id] += $to_add;
                        $tmp_towns_info[$key][1] -= $to_add;
                        if ($tmp_towns_info[$key][1] == 0){
                            unset($tmp_towns_info[$key]);
                        }
                    }
                }
                
                unset($tmp_resources_info[$smallest_cap_id]);

                
                
            } else {
                // In this case we need to know which resources do we need to employ
                // Sum all the population we can employ
                $employable_pop = $smallest_pop*(sizeof($tmp_towns_info));
                // Divide it by the number of resources
                $rest = $employable_pop%sizeof($tmp_resources_info);
                $pop_per_res = $employable_pop/sizeof($tmp_resources_info);
                // For each resource
                foreach ($tmp_resources_info as $res_key => $res_info){
                    $res_id = $res_info[0];
                    if ($rest != 0){
                        $pop_per_res_final = $pop_per_res + 1;
                        $rest -= 1;
                    } else {
                        $pop_per_res_final = $pop_per_res;
                    }
                    
                    $pop_per_town = $pop_per_res_final/sizeof($tmp_towns_info);
                    $pop_per_town_rest = $pop_per_res_final%sizeof($tmp_towns_info);
                    
                    // assign town's pop
                    foreach ($tmp_towns_info as $town_key => $town_info){
                        if ($pop_per_town_rest != 0){
                            $pop_to_res = $pop_per_town + 1;
                            $pop_per_town_rest -= 1;
                        } else {
                            $pop_to_res = $pop_per_town;
                        }
                        $town_id = $town_info[0];
                        $changes[$res_id][$town_id] += $pop_to_res;
                        $tmp_towns_info[$town_key][1] -= $pop_to_res;
                        if ($tmp_towns_info[$town_key][1] == 0){
                            unset($tmp_towns_info[$town_key]);
                        }
                        $tmp_resources_info[$res_key][1] -= $pop_to_res;
                    }
                }
            }
            

        } else{
            
            foreach ($tmp_resources_info as $key => $res_info){
                
                $res_id = $res_info[0];
                $res_cap = $res_info[1];
                
                $rest = $res_cap%sizeof($tmp_towns_info);
                $to_add = $res_cap/sizeof($tmp_towns_info);

                foreach ($tmp_towns_info as $key => $town_info){
                    $town_id = $town_info[0];
                    if ($rest){
                        $changes[$res_id][$town_id] +=  $to_add + 1;
                        $rest -= 1;
                    } else {
                        $changes[$res_id][$town_id] += $to_add;
                    }
                }
            }
            
            $finished = True;

        }
        $counter += 1;
    } while(!$finished || $counter > $counter_limit);
    
    foreach ($changes as $res_id => $value){
        foreach ($value as $town_id => $pop){
            $jobs_query = mysqli_prepare($db,
                'INSERT INTO land_res_jobs(town_id, people, working_at) VALUES (?,?,?)');
            mysqli_stmt_bind_param($jobs_query, "iii", $town_id, $pop, $res_id);
            mysqli_stmt_execute($jobs_query);
            mysqli_stmt_close($jobs_query);

        }
    }
    
}
