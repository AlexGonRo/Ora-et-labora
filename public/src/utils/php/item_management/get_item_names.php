<?php

function get_item_names($item_ids){
    
    $items_qm = implode(',', array_fill(0, count($item_ids), '?'));
    $item_types = implode('', array_fill(0, count($item_ids), 'i'));
    
    $items_query = mysqli_prepare($GLOBALS['db'],
        'SELECT name FROM item_info WHERE id IN ('.$items_qm.')');
    mysqli_stmt_bind_param($items_query, $item_types, ...$item_ids);
    mysqli_stmt_bind_result($items_query, $item_name);
    mysqli_stmt_execute($items_query);
    $names = array();
    $i = 0;
    while (mysqli_stmt_fetch($items_query)) {
        $names[$item_ids[$i]] = $item_name;
        $i++;
    }
    mysqli_stmt_close($items_query);
    
    return $names;
}
