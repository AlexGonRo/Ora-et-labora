<?php

function available_tasks($user_id){
    $available_tasks = array('--', 'cocinar', 'talar', 'pastorear', 'labrar');
    
    $get_role_query = mysqli_prepare($GLOBALS['db'],
        'SELECT role FROM users WHERE id = ?');
    mysqli_stmt_bind_param($get_role_query, "i", $_SESSION['user_id']);
    mysqli_stmt_bind_result($get_role_query, $role);
    mysqli_stmt_execute($get_role_query);
    mysqli_stmt_fetch($get_role_query);
    mysqli_stmt_close($get_role_query);
            
    if ($role){
        $available_tasks[] = 'oficiar misa';
    }
            
    return $available_tasks;
    
}


