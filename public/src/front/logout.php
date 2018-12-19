<?php

require '../private/vars/global_vars.php';
require '../utils/php/cookie_management/auth_cookie.php';
require '../private//db_connect.php';


/* 
 * Destroy session
 */
session_start();
session_unset();
session_destroy();

/*
 * Destroy authentication cookie if exists
 */
if (isset($_COOKIE["selector"]) && isset($_COOKIE["validator"])) {
    delete_server_cookie($_COOKIE["selector"]);
    delete_user_cookie();
}

header('location: ./login.php');
