<?php
const DB_SERVER = 'localhost';
const DB_USERNAME = 'root';
const DB_PASSWORD = '';
const DB_NAME = 'radiant';

session_start();
require_once("functions.php");

$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($mysqli->connect_errno) {
    echo "Failed to connect to MYSQL " . $mysqli->connect_error;
    exit();
}

// $mysqli -> close();
