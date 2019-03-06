<?php
session_start(); 
require '../../private/db_connect.php';
require '../../utils/php/other/verify_user.php';
require '../../utils/php/other/render_left_menu.php';

require '../../utils/php/movement/movement.php';


// Did the call for this page included a predefined filter?

// TODO

// Get all available offers

$market_query = mysqli_prepare($db,
    "SELECT id, item_id, quantity, price, seller_id "
        . "FROM market "
        . "ORDER BY item_id ASC");
mysqli_stmt_bind_result($market_query, $offer_id, $offer_item_id, $offer_quantity,
        $offer_price, $offer_seller_id);
mysqli_stmt_execute($market_query);
mysqli_stmt_store_result($market_query);
mysqli_stmt_fetch($market_query);

$offers = array();
while(mysqli_stmt_fetch($market_query)) {
    
    // If the seller of this offer is the user asking for the page, just ignore the row
    if($offer_seller_id==$_SESSION['user_id']){
        continue;
    }
    
    // For each offer, let's get (or compute) relevant information
    // Get info about the seller
    $seller_info_query = mysqli_prepare($db,
        "SELECT a.username, b.kingdom_id, b.name "
            . "FROM users AS a INNER JOIN kingdoms AS b ON a.kingdom_id=b.id "
            . "WHERE a.id= ? ");

    mysqli_stmt_bind_param($seller_info_query, "i", $offer_seller_id);
    mysqli_stmt_bind_result($seller_info_query, $seller_name, $seller_kingdom_id, $seller_kingdom_name);
    mysqli_stmt_execute($seller_info_query);
    mysqli_stmt_fetch($seller_info_query);
    mysqli_stmt_close($seller_info_query);
    // Get info about the final destination
    $region_info_query = mysqli_prepare($db,
        "SELECT b.id, b.name "
            . "FROM castles_monasteries AS a INNER JOIN regions AS b ON a.region_id = b.id "
            . "WHERE a.owner_id = ? ");

    mysqli_stmt_bind_param($region_info_query, "i", $_SESSION['user_id']);
    mysqli_stmt_bind_result($region_info_query, $seller_region_id, $seller_region_name);
    mysqli_stmt_execute($region_info_query);
    mysqli_stmt_fetch($region_info_query);
    mysqli_stmt_close($region_info_query);
    // Get info about the current player (where is he?)
    $buyer_info_query = mysqli_prepare($db,
        "SELECT region_id "
            . "FROM castles_monasteries "
            . "WHERE a.owner_id= ? ");

    mysqli_stmt_bind_param($buyer_info_query, "i", $_SESSION['user_id']);
    mysqli_stmt_bind_result($buyer_info_query, $buyer_region_id);
    mysqli_stmt_execute($buyer_info_query);
    mysqli_stmt_fetch($buyer_info_query);
    mysqli_stmt_close($buyer_info_query);
    
    // Get info about the route
    $route = get_route($seller_region_id, $buyer_region_id);
    $route_time, $avg_security, $taxes = 
    
    
    // Rearange all the info we just got
    $offers[] = array(
        'id' => $offer_id,
        'item_id' => $offer_item_id,
        'quantity' => $offer_quantity,
        'price' => $offer_price,
        'seller_id' => $offer_seller_id,
        'seller_name' => $seller_name,
        'region_id' => $seller_region_id,
        'region_name' => $seller_region_name,
        'kingdom_id' => $seller_kingdom_id,
        'kingdom_name' => $seller_kingdom_name,
        'route' => $route, 
        'route_time' => $route_time,
        'avg_security' => $avg_security,
        'taxes' => $taxes
    );

}
mysqli_stmt_close($pm_query);



require 'tmpl/market.php';