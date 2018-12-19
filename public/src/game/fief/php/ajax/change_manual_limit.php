<?php
session_start(); 
require '../../../../private/db_connect.php';
require '../../../../utils/php/other/verify_user.php';

$user_id = $_SESSION['user_id'];
$resource_id = $_POST['resource_id'];
$new_limit = $_POST['new_limit'];

# Check that the resource belongs to the user!
$ownership_query = mysqli_prepare($db,
    'SELECT owner_id FROM land_resources WHERE id = ?');
mysqli_stmt_bind_param($ownership_query, "i", $resource_id);
mysqli_stmt_bind_result($ownership_query, $res_owner_id);
mysqli_stmt_execute($ownership_query);
mysqli_stmt_fetch($ownership_query);
mysqli_stmt_close($ownership_query);

if ($res_owner_id != $user_id){
    return;
}

# Check what's the maximum amount of people this resource can have
$cap_query = mysqli_prepare($db,
    'SELECT b.max_capacity '
        . 'FROM land_resources as a INNER JOIN land_resources_capacity as b ON a.resource=b.resource_id AND a.level=b.level '
        . 'WHERE a.id = ?');
mysqli_stmt_bind_param($cap_query, "i", $resource_id);
mysqli_stmt_bind_result($cap_query, $max_cap);
mysqli_stmt_execute($cap_query);
mysqli_stmt_fetch($cap_query);
mysqli_stmt_close($cap_query);


# Check that the user input is correct
if (!is_numeric($new_limit) || $new_limit > $max_cap || $new_limit < 0){
    return;
}

if($new_limit == $max_cap ){
    $new_limit = 'NULL';
}

$new_cap_query = mysqli_prepare($db,
    'UPDATE land_resources SET manual_limit=? WHERE id=?');
mysqli_stmt_bind_param($new_cap_query, "ii", $new_limit, $resource_id);
mysqli_stmt_execute($new_cap_query);
mysqli_stmt_close($new_cap_query);

        
echo $new_limit;