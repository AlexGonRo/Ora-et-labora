<?php 
session_start(); 
require '../../private/db_connect.php';
require '../../utils/php/other/verify_user.php';
require '../../utils/php/other/render_left_menu.php';

require "../../private/vars/building_vars.php";

require 'php/prod_options.php';


# Get kitchen id
$get_kit_id_query = mysqli_prepare($db,
    "SELECT a.id, a.building_id, name "
        . "FROM buildings AS a INNER JOIN buildings_info AS b "
        . "ON a.building_id = b.id "
        . "WHERE owner_id=? AND a.building_id=".KITCHEN_ID);
mysqli_stmt_bind_param($get_kit_id_query, "i", $_SESSION['user_id']);
mysqli_stmt_bind_result($get_kit_id_query, $user_building_id, $building_id, $name);
mysqli_stmt_execute($get_kit_id_query);

while (mysqli_stmt_fetch($get_kit_id_query)){
    if ($building_id == KITCHEN_ID){
      $my_kitchen_id = $user_building_id;
      $main_building_id = $building_id;
    }
}

mysqli_stmt_close($get_kit_id_query);


# Get a list of all the items we can produce in the kitchen
list($kitchen_prod_options_ids, $kitchen_prod_options_names, $kit_prod_img) = prod_options(KITCHEN_ID);
# Code the recipes in a text format so the user can understand
# TODO We have html text here in the PHP section. Not good
$kitchen_text_recipes = array();
foreach ($kitchen_prod_options_names as $item=>$ingredients_array){ 
    $text = "<img src='../../../".$kit_prod_img[$item]."' style='vertical-align: text-top;' height='16px' width='16px'> ";
    $text .= ucfirst($item)." <= ";
    foreach ($ingredients_array as $ing){
        $text = $text 
                . "<img src='../../../".$kit_prod_img[$ing[0]]."' style='vertical-align: text-top;' height='16px' width='16px'> " # Image 
                . lcfirst($ing[0]) ."($ing[1]), ";  #Text
    }
    $text = substr($text, 0, -2);   # Delete last space and colon
    $kitchen_text_recipes[$item] = $text;
}


# List the production queue of the kitchen
$get_prod_query = mysqli_prepare($db,
    'SELECT user_prod.id as prod_id, item_id, quantity, name '
        . 'FROM user_prod INNER JOIN item_info ON user_prod.item_id = item_info.id '
        . 'WHERE user_building_id=? ORDER BY user_prod.id');
mysqli_stmt_bind_param($get_prod_query, "i", $my_kitchen_id);
mysqli_stmt_bind_result($get_prod_query, $prod_id, $item_id, $quantity, $item_name);
mysqli_stmt_execute($get_prod_query);
mysqli_stmt_store_result($get_prod_query);

            
$kit_prod_items = array();
while (mysqli_stmt_fetch($get_prod_query)) {
    $kit_prod_items[$prod_id] = [$item_name, $quantity];
}

mysqli_stmt_close($get_prod_query);


# In case we have some GET information about which tab we should open first
$open_kitchen = False;
if(isset($_GET['tab'])) {
    if ($_GET['tab']=='Cocina'){
        $open_kitchen = True;
    }
}




require 'tmpl/produce.php';