<?php
$host = "localhost"; // Location or address of the database server
$db_user = "root"; // The username of the database
$db_pass = ""; // The password of the database
$db_name= "practice_php"; // The database name 

// This create connection with MySql database
$conn = new mysqli($host, $db_user, $db_pass, $db_name);

// This check the connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
