<?php

function select_resource_by_id($res_id){
    
    $resource_info_query = mysqli_prepare($GLOBALS['db'],
        'SELECT a.id, b.name, region_id, level, status, manual_limit, owner_id,	'
            . 'duchy_tax, royal_tax, town_id '
            . 'FROM land_resources AS a INNER JOIN land_resources_names AS b ON a.resource=b.id '
            . 'WHERE a.id = ? LIMIT 1');
    mysqli_stmt_bind_param($resource_info_query, "i", $res_id);
    mysqli_stmt_bind_result($resource_info_query, $resource_id, $resource_type, $region_id, $level, $status, $manual_limit, $owner_id, $duchy_tax, $royal_tax, $town_id);
    mysqli_stmt_execute($resource_info_query);
    mysqli_stmt_fetch($resource_info_query);
    mysqli_stmt_close($resource_info_query);
    
    return array('id' => $resource_id,
        'type' => $resource_type,
        'region_id' => $region_id,
        'level' => $level,
        'status' => $status,
        'manual_limit' => $manual_limit,
        'owner_id' => $owner_id,
        'duchy_tax' => $duchy_tax,
        'royal_tax' => $royal_tax,
        'town_id' => $town_id
        );
    
}
