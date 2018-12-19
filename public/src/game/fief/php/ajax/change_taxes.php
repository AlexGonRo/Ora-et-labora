<?php
session_start(); 
require '../../../../private/db_connect.php';
require '../../../../utils/php/other/verify_user.php';

$user_id = $_SESSION['user_id'];
$town_id = $_POST['town_id'];
$new_taxes = $_POST['new_taxes'];

# Check that the value is correct
if (!is_numeric($new_taxes) || $new_taxes < 0 || $new_taxes > 100){
    return;
}

# Check that the town belongs to the user
$ownership_query = mysqli_prepare($db,
    'SELECT owner_id FROM towns WHERE id = ?');
mysqli_stmt_bind_param($ownership_query, "i", $town_id);
mysqli_stmt_bind_result($ownership_query, $town_owner_id);
mysqli_stmt_execute($ownership_query);
mysqli_stmt_fetch($ownership_query);
mysqli_stmt_close($ownership_query);

if ($town_owner_id != $user_id){
    return;
}

# Change taxes
$new_tax_query = mysqli_prepare($db,
    'UPDATE towns SET local_tax=? WHERE id=?');
mysqli_stmt_bind_param($new_tax_query, "ii", $new_taxes, $town_id);
mysqli_stmt_execute($new_tax_query);
mysqli_stmt_close($new_tax_query);

        
echo $new_taxes;