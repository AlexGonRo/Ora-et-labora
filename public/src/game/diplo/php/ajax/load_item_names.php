<?php
session_start(); 
require '../../../../private/db_connect.php';
require '../../../../utils/php/other/verify_user.php';


$result = array();

$items_query = mysqli_prepare($GLOBALS['db'],
    'SELECT id, name FROM item_info ORDER BY name DESC');
mysqli_stmt_bind_result($items_query, $item_id, $item_name);
mysqli_stmt_execute($items_query);

while (mysqli_stmt_fetch($items_query)) {
    $tmp = array( 'id' => $item_id,
        'name' =>$item_name);
    array_push($result, $tmp);
}
mysqli_stmt_close($items_query);





echo json_encode($result);

