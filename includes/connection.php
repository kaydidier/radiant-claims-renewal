<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'radiant');

$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);//create connection
$db = mysqli_select_db($con, DB_NAME);//to select from the db

session_start();
require_once("functions.php");
?>