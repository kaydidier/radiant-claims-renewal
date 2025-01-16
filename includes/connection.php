<?php
$con=mysql_connect("localhost","root","");//create connection
$db=mysql_select_db("radiant");//to select from the db
session_start();
require_once("functions.php");
?>