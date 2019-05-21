<?php
require '../../../../../public/src/private/db_connect.php';

$borders_query = mysqli_prepare($db,
    "SELECT region_1_id, region_2_id, type from borders");

mysqli_stmt_bind_result($borders_query, $region_1, $region_2, $border_type);
mysqli_stmt_execute($borders_query);
mysqli_stmt_store_result($borders_query);

while (mysqli_stmt_fetch($borders_query)) {

    $new_border_query = mysqli_prepare($GLOBALS['db'],
        "INSERT INTO borders (region_1_id, region_2_id, type) VALUES (?,?,?)");
    mysqli_stmt_bind_param($new_border_query, "iis", $region_2, $region_1, $border_type);
    mysqli_stmt_execute($new_border_query);
    mysqli_stmt_close($new_border_query);
    
}

mysqli_stmt_close($borders_query);