<?php

session_start(); 
require '../../private/db_connect.php';
require '../../utils/php/other/verify_user.php';
require '../../utils/php/other/render_left_menu.php';

$fame_query = mysqli_prepare($db,
    'SELECT fame, fame_last_update, username, id '
      . 'FROM users '
      . 'ORDER BY fame DESC, fame_last_update DESC');
mysqli_stmt_bind_result($fame_query, $fame, $last_update, $username, $id);
mysqli_stmt_execute($fame_query);

$fame_entries = array();
        
while (mysqli_stmt_fetch($fame_query)){
      $tmp = array();
      $tmp['id'] = $id;
      $tmp['username'] = $username;
      $tmp['fame'] = $fame;
      $tmp['last_update'] = $last_update;
      $fame_entries[] = $tmp;
}
mysqli_stmt_close($fame_query);

require_once 'tmpl/index.php';

