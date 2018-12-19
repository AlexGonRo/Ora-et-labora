<?php
session_start(); 
require '../../../../private/db_connect.php';
require '../../../../utils/php/other/verify_user.php';
require '../../../../utils/php/user/select_belongings.php';

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
    
    if (!isset($user_id) || $user_id='' || ($side == 'demand' && $user_id=$_SESSION['user_id'])){
        header('Content-Type: text/html; charset=utf-8');
        header('HTTP/1.1 418 Incluso una tetera sabría escribir un destinatario que exista :)');
        return;
        
    }
}


$towns = select_towns($user_id);

$result = array();

foreach($towns as $town) { 
    if ($town['type'==0]){
      $tmp = array ('id' => $town['id'],
          'name' => "Pueblo de ".$town['name']); 
      array_push($result, $tmp);
    } else {
      $tmp = array ('id' => $town['id'],
          'name' => "Villa de ".$town['name']); 
      array_push($result, $tmp);
    }
}


echo json_encode($result);