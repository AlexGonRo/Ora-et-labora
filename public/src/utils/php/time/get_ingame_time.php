<?php

/**
 * Retrieve the in-game time and how many days the time moves forward each cycle.
 * 
 * 
 * @return array(int, int, int, int) day, month, year and time speed.
 */
function get_ingame_time(){
    
    $time_query = mysqli_prepare($GLOBALS['db'],
        "SELECT value_number, value_char FROM variables WHERE name='time'");
    mysqli_stmt_bind_result($time_query, $time_speed, $my_time);
    mysqli_stmt_execute($time_query);
    mysqli_stmt_fetch($time_query);
    
    $day = explode('_',$my_time)[0];
    $month = explode('_',$my_time)[1];
    $year = explode('_',$my_time)[2];
    
    mysqli_stmt_close($time_query);
    
    return array($day, $month, $year, $time_speed);
}

/**
 * Retrieve the current in-game cycle.
 * 
 * @return int
 */
function get_ingame_cycle(){
    
    $time_query = mysqli_prepare($GLOBALS['db'],
        "SELECT value_number FROM variables WHERE name='cycle'");
    mysqli_stmt_bind_result($time_query, $cycle);
    mysqli_stmt_execute($time_query);
    mysqli_stmt_fetch($time_query);

    
    mysqli_stmt_close($time_query);
    
    return $cycle;
}