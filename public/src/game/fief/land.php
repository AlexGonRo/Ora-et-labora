<?php 
session_start(); 
require '../../private/db_connect.php';
require '../../utils/php/other/verify_user.php';
require '../../utils/php/other/render_left_menu.php';

require '../../utils/php/land_res/get_res_name.php';
require '../../utils/php/land_res/select_res.php';
require '../../utils/php/names/get_name.php';
require '../../utils/php/user/select_belongings.php';

$is_get = False;
if ($_GET) {
    
    $res_id = $_GET['id'];
    $my_res = select_resource_by_id($res_id);
    $res_complete_name =  get_res_type_name($my_res['type'])." en ".get_region_name($my_res['region_id']);
    $is_get = True;
    
} else {
    
    # Get a list of all the resources of this user
    $resources = select_resources($_SESSION['user_id']);

    # Create a list with the complete names of these resources (name+location)
    $res_complete_names = array();
    foreach($resources as $res) { 

        $res_complete_names[$res['resource_id']] =  $res['resource_name']." en ".$res['region_name'];
    }
    
}

require 'tmpl/land.php';

