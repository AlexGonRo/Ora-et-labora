<?php

function compute_turns_left($current_day, $current_month, $current_year, 
        $deadline_day, $deadline_month, $deadline_year, $step_forward){
    $turns_left = 0;
    $month_dur = array(0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);    # TODO We do not account for leap-years
    #Let's keep moving forward until we reach the deadline
    while ($current_day < $deadline_day || $current_month < $deadline_month || $current_year < $deadline_year){
        $turns_left += 1;
        $current_day += $step_forward;
        if ($current_day > $month_dur[$current_month]){
            $current_day -= $month_dur[$current_month];
            $current_month += 1;
        }
        if ($current_month > 12){
            $current_month = 1;
            $current_year += 1;
        }
    }
    return $turns_left;
}

function get_deadline($current_month, $current_year, $start_month, $end_month, $prepared){
    // TODO This function really needs to be tested again
    # Let's compute how many turns are left until the harvest starts/ends
    $month_names = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre', 'Enero');
    if ($current_month >= $start_month && $current_month <= $end_month && $prepared){ # The harvest is already active   // TODO This formula gives problems if harvest seasson happens in months such as december
        if ($end_month==12){
            $deadline_day = 1;
            $deadline_month = 1;
            $deadline_year = $current_year+1;
        } else {
            $deadline_day = 1;
            $deadline_month = $end_month+1;
            $deadline_year = $current_year;
        }
    } else { # This deadline is for a harvest that has not started already

        if (!$prepared){
            if ($current_month > $start_month){
                    $deadline_day = 1;
                    $deadline_month = $start_month;
                    $deadline_year = $current_year+2;
            } else {
                    $deadline_day = 1;
                    $deadline_month = $start_month;
                    $deadline_year = $current_year+1;
            }
        } else {
            if ($current_month > $start_month){
                $deadline_day = 1;
                $deadline_month = $start_month;
                $deadline_year = $current_year+1;
            } else {
                $deadline_day = 1;
                $deadline_month = $start_month;
                $deadline_year = $current_year+1;
            }
        }

    }
    
    return array($deadline_day, $deadline_month, $deadline_year);
}