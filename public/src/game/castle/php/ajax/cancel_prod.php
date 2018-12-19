<?php
session_start(); 
require '../../../../private/db_connect.php';
require '../../../../utils/php/other/verify_user.php';

$prod_id = $_POST['prod_id'];


# Check that that production is, in fact, from the user that clicked the button

$get_id_query = mysqli_prepare($db,
    'SELECT owner_id FROM user_prod WHERE id = ?');
mysqli_stmt_bind_param($get_id_query, "i", $prod_id);
mysqli_stmt_bind_result($get_id_query, $prod_owner);
mysqli_stmt_execute($get_id_query);
mysqli_stmt_fetch($get_id_query);
mysqli_stmt_close($get_id_query);

if ($prod_owner == $_SESSION['user_id']){
    # Delete production
    $del_prod_query = mysqli_prepare($db,
        'DELETE FROM user_prod WHERE id = ?');
    mysqli_stmt_bind_param($del_prod_query, "i", $prod_id);
    mysqli_stmt_execute($del_prod_query);
    mysqli_stmt_close($del_prod_query);

    echo "success";
}