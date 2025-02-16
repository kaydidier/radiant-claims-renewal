<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'radiant');

session_start();
require_once("functions.php");

try {
    $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($mysqli->connect_error) {
        throw new Exception("Failed to connect to MySQL: " . $mysqli->connect_error);
    }
} catch (Exception $e) {
    die($e->getMessage());
}

// $mysqli -> close();
