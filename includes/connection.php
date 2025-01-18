<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'radiant');

session_start();
require_once("functions.php");

$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($mysqli -> connect_errno){
    echo "Failed to connect to MYSQL ". $mysqli -> connect_error;
    exit();
}

// $mysqli -> close();
