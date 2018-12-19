<?php 
session_start(); 
require '../../private/db_connect.php';
require '../../utils/php/other/verify_user.php';
require '../../utils/php/other/render_left_menu.php';

require '../../utils/php/user/select_belongings.php';
require '../../utils/php/names/get_name.php';


$is_get = False;
if ($_GET) {
    
    $town_id = $_GET['id'];
    $town_name = get_town_complete_name_by_id($town_id);
    $is_get = True;
    
} else {

    $towns = select_towns($_SESSION['user_id']);

    $towns_complete_names = array();    # Town type + Town name
    foreach($towns as $town) { 
        if ($town['type']==0){
          $towns_complete_names[$town['id']] =  "Pueblo de ".$town['name'];
        } else {
          $towns_complete_names[$town['id']] =  "Villa de ".$town['name'];
        }
    } 
}
        

require 'tmpl/towns.php';


              
