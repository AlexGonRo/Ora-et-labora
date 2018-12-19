<?php

function get_res_type_name($res_db_name){
    $name = "";
    if($res_db_name=='field'){
        $name = "Campo";
    } else if ($res_db_name=='forest'){
        $name = "Bosque";
    } else if ($res_db_name=='coast'){
        $name = "Zona costera";
    } else if ($res_db_name=='quarry'){
        $name = "Cantera";
    } else if ($res_db_name=='gold mine'){
        $name = "Mina de oro";
    } else if ($res_db_name=='iron mine'){
        $name = "Mina de hierro";
    } else if ($res_db_name=='silver mine'){
        $name = "Mina de plata";
    } else if ($res_db_name=='copper mine'){
        $name = "Mina de cobre";
    } else if ($res_db_name=='river'){
        $name = "Río";
    } else if ($res_db_name=='clay mine'){
        $name = "Mina de arcilla";
    }
    return $name;
}
