<?php 
session_start(); 
require '../../private/db_connect.php';
require '../../utils/php/other/verify_user.php';
require '../../utils/php/other/render_left_menu.php';

# Get notifications

$alerts = array();

# Get information about vassals

$vassals = array();

# Get information about villages

$villages = array();

# Get information bout land resources

$land_res = array();




require 'tmpl/index.php';