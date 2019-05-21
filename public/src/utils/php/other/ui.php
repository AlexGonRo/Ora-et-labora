<?php

require_once BASE_PATH_PUBLIC.'src/private/vars/ui_vars.php';


function get_space_bar_class($occupied, $max_cap){
    
    if($occupied/$max_cap <= FREE_SPACE_BAR_GOOD){
        $space_bar_class = "bg-success";
    } else if($occupied/$max_cap <= FREE_SPACE_BAR_WARNING) {
        $space_bar_class = "bg-warning";
    } else {
        $space_bar_class = "bg-danger";
    }
    
    return $space_bar_class;
}

function get_stars($num){
    $result = "";

    # Get the full stars first
    $stars = $num / POINTS_STAR;    
    for( $i = 0; $i<$stars; $i++ ){
        $result .= "<img style='vertical-align:central;' src=".BASE_PATH_PUBLIC."img/icons/other/star.png' alt='$num' height='16px' width='16px'>";
        
    }
    
    # Check if we should add a half star
    if ($num % POINTS_STAR >= POINTS_STAR / 2){
        $result .= "<img style='vertical-align:central;' src=".BASE_PATH_PUBLIC."img/icons/other/half_star.png' alt='$num' height='16px' width='16px'>";
    }
    
    return $result;
    
}

