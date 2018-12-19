<?php

function generate_date_birth($date, $age = null, $min_age = null, $max_age = null){
    # Generate age
    if (is_null($age)){
        $age = rand($min_age, $max_age);
    }
    # Divide date format
    $current_date = explode("_", $date);
    # Generate the month of birth and compute which one it is
    $minus_month = rand(0, 12);
    $birth_month = $current_date[1] - $minus_month;
    if ($birth_month<=0){
        $birth_month + 12;
    }
    # Create date of birth
    $birth_date = "1_".$current_date[1]."_".((int)$current_date[2] - $age);
    return $birth_date;
}
