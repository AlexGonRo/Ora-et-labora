<?php
session_start(); 
require '../../../../private/db_connect.php';
require '../../../../utils/php/other/verify_user.php';
require '../../../../utils/php/user/select_belongings.php';
require '../../../../utils/php/land_res/get_res_name.php';

$username = $_POST['msg_ben'];
$side = $_POST['side'];
if ($side == 'offer'){
    $user_id = $_SESSION['user_id'];
} else {
    // Look for a similar username in the databse
    $username_query = mysqli_prepare($GLOBALS['db'],
        'SELECT id FROM users WHERE username = ? LIMIT 1');
    mysqli_stmt_bind_result($username_query, $user_id);
    mysqli_stmt_execute($username_query);
    mysqli_stmt_fetch($username_query);
    mysqli_stmt_close($username_query);
    
    if (!isset($user_id) || $user_id='' || ($side == 'demand' && $user_id=$_SESSION['user_id']) ){
        header('HTTP/1.1 418 Incluso una tetera sabría escribir un destinatario que exista ;)');
        return;
        
    }
}

$resources = select_resources($user_id);

$result = array();

foreach($resources as $res) { 
    $name = get_res_type_name($res['resource_name']);
    
    $tmp = array("id" => $res["resource_id"],
        "name" => $name." en ".$res['region_name']);
    array_push($result, $tmp);
     
  }

echo json_encode($result);
  