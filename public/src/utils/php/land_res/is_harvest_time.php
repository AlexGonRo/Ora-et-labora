<?php


function is_harvest_time($month, $start, $end, $ready=true){
    
    if(!$ready){
        return false;
    }
    
    if ($end < $start){
        $end += 12;  # If the starting month is bigger than the ending one, 
                     # that means it are one year ahead
    }
    
    if ($month > $start && $month < $end){
        return true;
    } else {
        return false;
    }

}

