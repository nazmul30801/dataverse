<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dataverse";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
	$error = $conn->connect_error;
} 