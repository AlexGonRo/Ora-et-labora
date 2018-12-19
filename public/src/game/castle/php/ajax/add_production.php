<?php
session_start(); 
require '../../../../private/db_connect.php';
require '../../../../utils/php/other/verify_user.php';

$item_name = $_POST['item_name'];
$quantity = $_POST['quantity'];
$building_id = $_POST['building_id'];
$user_id = $_SESSION['user_id'];

# Security check: Does this building belong to the user?
$building_owner_query = mysqli_prepare($db,
    'SELECT owner_id FROM buildings WHERE id=?');
mysqli_stmt_bind_param($building_owner_query, "i", $building_id);
mysqli_stmt_bind_result($building_owner_query, $owner_id);
mysqli_stmt_execute($building_owner_query);
mysqli_stmt_fetch($building_owner_query);
mysqli_stmt_close($building_owner_query);

if($owner_id != $_SESSION['user_id']){
    return;
}


# Get item id with name
$item_name_query = mysqli_prepare($db,
    'SELECT id FROM item_info WHERE name=?');
mysqli_stmt_bind_param($item_name_query, "s", $item_name);
mysqli_stmt_bind_result($item_name_query, $item_id);
mysqli_stmt_execute($item_name_query);
mysqli_stmt_fetch($item_name_query);
mysqli_stmt_close($item_name_query);

# Insert production
$insert_prod_query = mysqli_prepare($db,
    'INSERT INTO user_prod(item_id, quantity, owner_id, user_building_id) VALUES (?,?,?,?)');
mysqli_stmt_bind_param($insert_prod_query, "iiii", $item_id, $quantity, $user_id, $building_id);
mysqli_stmt_execute($insert_prod_query);
mysqli_stmt_close($insert_prod_query);

# Get ID of the production we just started
$get_id_query = mysqli_prepare($db,
    'SELECT id FROM user_prod WHERE owner_id=? ORDER BY id DESC LIMIT 1');
mysqli_stmt_bind_param($get_id_query, "i", $_SESSION['user_id']);
mysqli_stmt_bind_result($get_id_query, $prod_id);
mysqli_stmt_execute($get_id_query);
mysqli_stmt_fetch($get_id_query);
mysqli_stmt_close($get_id_query);


echo json_encode(array('prod_id' => $prod_id)); 

