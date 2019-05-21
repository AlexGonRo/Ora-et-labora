<?php 
session_start(); 
require '../../private/db_connect.php';
require '../../utils/php/other/verify_user.php';
require '../../utils/php/other/render_left_menu.php';

require "../../private/vars/item_vars.php";
require "../../private/vars/building_vars.php";
require "../../private/vars/utils_vars.php";

require '../../utils/php/building/compute_space.php';
require '../../utils/php/time/get_ingame_time.php';
require '../../utils/php/item_management/get_item_info.php';
require '../../utils/php/item_management/get_item_usage_record.php';
require '../../utils/php/other/ui.php';
require '../../utils/php/news_alerts/get_news_alerts.php';


$balance_cycles = 4;


/*
 * GET INFORMATION RELATED TO THE NOTIFICATIONS PART
 */

$alerts = get_alerts(ALERT_TYPE_CASTLE);

/*
 * GET INFORMATION RELATED TO THE BUILDINGS AND WORKERS
 */

// TODO
// Check user has a garden and/or stable

// Check for events related to workers


/**
 * GET INFORMATION RELATED TO THE ITEMS
 */

// Get buildings info

list($pantry_occupied, $pantry_max_cap) = compute_pantry_space($db, $_SESSION['user_id']);
$pantry_space_bar_type = get_space_bar_class($pantry_occupied, $pantry_max_cap);


list($ware_occupied, $ware_max_cap) = compute_warehouse_space($db, $_SESSION['user_id']);
$ware_space_bar_type =  get_space_bar_class($ware_occupied, $ware_max_cap);


// Get balance info

$raw_food_balance = get_balance_info(RAW_FOOD_CLASS, $balance_cycles);



require 'tmpl/index.php';




