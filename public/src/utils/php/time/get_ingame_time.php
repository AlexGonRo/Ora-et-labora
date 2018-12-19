<?php

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