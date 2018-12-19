<?php

require_once 'vars/global_vars.php';

function connect_db(){
   # If variables were in an ini file, do:
   $config = parse_ini_file(BASE_PATH_PRIVATE.'config.ini'); 

   $db = mysqli_connect($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);

   return $db;
}