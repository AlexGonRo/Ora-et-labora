<?php

require_once BASE_PATH_PUBLIC.'src/utils/php/time/get_ingame_time.php';


function update_ready_fields(){
    
    list($day, $month, $year) = get_ingame_time();
    
    # Get all unprepared fields
    $field_query = mysqli_prepare($GLOBALS['db'],
            'SELECT resource_id, end '
                . 'FROM field_resource AS a INNER JOIN field_resource_info AS b ON a.growing=b.id '
                . 'WHERE a.ready=0');
    mysqli_stmt_bind_result($field_query, $res_id, $end_month);
    mysqli_stmt_execute($field_query);
    while (mysqli_stmt_fetch($field_query)){
        # Did we just end the harvesting season? Then turn field to prepared
        if ($month == $end_month+1 || ($month==1 && $end_month==12)){
            $upd_field_query = mysqli_prepare($GLOBALS['db'],
                    'UPDATE field_resource '
                    . 'SET ready=1 '
                    . 'WHERE resource_id=?');
            mysqli_stmt_bind_param($upd_field_query, 'i', $res_id);
            mysqli_stmt_execute($upd_field_query);
            mysqli_stmt_close($upd_field_query);
        }
    }
    mysqli_stmt_close($field_query);
}

