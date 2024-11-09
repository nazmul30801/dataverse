<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shekor";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
	$dbconn = 0;
	$error = $conn->connect_error;
} 