<?php
//start session
session_start();

//create constants
define('SITEURL', 'http://localhost:7080/food-order/');
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'food-order');
//create connection

$conn = new mysqli(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
//check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
