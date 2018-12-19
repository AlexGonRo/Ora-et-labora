<?php
session_start(); 
require '../../../../private/db_connect.php';
require '../../../../utils/php/other/verify_user.php';

$town_query = mysqli_prepare($db,
    'SELECT a.id, a.name, b.name '
        . 'FROM towns AS a INNER JOIN regions AS b ON a.region_id=b.id '
        . 'WHERE a.owner_id=-1 AND type=1 '
        . 'ORDER BY a.name ASC');
mysqli_stmt_bind_result($town_query, $town_id, $town_name, $region_name);
mysqli_stmt_execute($town_query);

$return_arr = array();
while(mysqli_stmt_fetch($town_query)){
    $return_arr[] = array("town_id"=>$town_id, "town_name" => $town_name, "region_name" => $region_name);
}
mysqli_stmt_close($town_query);


echo json_encode($return_arr);
