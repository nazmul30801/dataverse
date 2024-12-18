<?php

// ---------------[Main Functions]---------------

function create_connection($database = "dataverse")
{
	$servername = "localhost";
	$username = "root";
	$password = "";
	// Create connection
	$connection = new mysqli($servername, $username, $password, $database);

	// Check connection
	if ($connection->connect_error) {
		echo $connection->connect_error;
	}
	return $connection;
}

function sql_query($sql, $database = "dataverse")
{
	
	$connection = create_connection($database);
	$result = $connection->query($sql);
	$connection->close();
	return $result;
}




// ---------------[Search Engin Functions]---------------

function make_sql($search_term, $table, $columns_array)
{
	$result_column = sql_query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table' AND TABLE_SCHEMA = 'dataverse'");
	if ($result_column->num_rows > 0) {
		// output data of each row
		$sql = "";
		while ($columns = $result_column->fetch_assoc()) {
			$column = $columns["COLUMN_NAME"];
			$sql .= "SELECT `{$columns_array[0]}`, `{$columns_array[1]}`, '$column' AS column_name, `$column` AS value FROM `$table` WHERE `$column` LIKE '%$search_term%' UNION ";
		}
		$sql = substr($sql, 0, -7);
		$sql = $sql . ";";
		return $sql;
	}
}


function view_section($section, $status = 1)
{
	if ($status == 1) {
		echo $section;
	}
}




// ---------------[Caller ID Functions]---------------


function make_condition($name, $column)
{
	if ($name != "") {
		$condition = " AND `" . $column . "` LIKE '%" . $name . "%'";
	} else {
		$condition = "";
	}
	return $condition;
}
function set_form_value($value_name)
{
	if (isset($_GET[$value_name])) {
		$var = htmlspecialchars($_GET[$value_name]);
	} else {
		$var = "";
	}
	return $var;
}


function upload($fileOnForm, $fileOnServer)
{
	$uploadState = 1;
	// Check if file already exists
	if (file_exists($fileOnServer)) {
		echo "File already exist.<br>";
		$uploadState = 0;
	}
	if ($fileOnForm["size"] > 5242880) {
		echo "File size is too large.<br>";
		$uploadState = 0;
	}
	if ($uploadState == 1) {
		if (move_uploaded_file($fileOnForm["tmp_name"], $fileOnServer)) {
			echo "Upload Done";
			return 1;
		} else {
			echo "Cant Upload";
		}
	} else {
		echo "There was a problem.";
		return 0;
	}
}


// Functin : Phone Number Formater
function formate_numb($number)
{
	if (strpos(" " . $number, "-")) {
		$number = str_replace("-", "", $number);
	}
	$number = trim($number);
	if (strpos(" " . $number, "01") == 1 and strlen($number) == 11) {
		$number = "+88" . $number;
	}
	if (strpos(" " . $number, "88") == 1 and strlen($number) == 13) {
		$number = "+" . $number;
	}
	return $number;
}


// Functin : VCF to SQL Converter
function vcf_to_array($vcf_file)
{
	$file = fopen($vcf_file, "r") or die("Unable to open - (" . $vcf_file . ").");
	$contacts = array("name" => array(), "number" => array());
	$state = 0;
	$name = "UnDefind";
	while (!feof($file)) {
		$line = fgets($file);
		if ($state == 0 and strpos(" " . $line, "BEGIN:VCARD")) {
			$state = 1;
		} elseif ($state == 1 and strpos(" " . $line, "FN:")) {
			$name = trim(substr($line, 3));
			$state = 2;
		} elseif ($state == 2 and (strpos(" " . $line, "TEL;CELL") or strpos(" " . $line, "TEL;HOME:"))) {
			if (strpos(" " . $line, "TEL;CELL;PREF:")) {
				$number = substr($line, 14);
			} else {
				$number = substr($line, 9);
			}
			$number = formate_numb($number);
			array_push($contacts["name"], $name);
			array_push($contacts["number"], $number);
		} elseif ($state == 2 and strpos(" " . $line, "END:VCARD")) {
			$state = 0;
		}
	}
	return $contacts;
}


function insert_contacts($vcf_file, $get_from)
{
	$contacts = vcf_to_array($vcf_file);
	$data = "";
	for ($i = 0; $i < count($contacts["number"]); $i += 1) {
		$data .= "\n(NULL, '" . $contacts["name"][$i] . "', '" . $contacts["number"][$i] . "', '" . $get_from . "'),";
	}
	$sql = "INSERT INTO `contacts` (`id`, `name`, `number`, `get_from`) \nVALUES " . substr_replace($data, ';', -1);

	// Create SQL file
	$sql_file = fopen("uploads/sql/" . $get_from . "'s Contacts.sql", "w") or die("Unable to Open File.");
	fwrite($sql_file, $sql);
	fclose($sql_file);

	// Insert Data on Database
	require "config/config.php";
	if ($conn->query($sql) === TRUE) {
		echo "Data inserted successfully.";
		return 1;
	} else {
		echo "Unable to Insert Data !";
		return 0;
	}
}







//  specific session variable remover 
function get_session_var ($variable_name) {
	session_start();
	if (isset($_SESSION[$variable_name])) {
		$variable = $_SESSION[$variable_name];
		unset($_SESSION[$variable_name]);
	} else {
		$variable = "";
	}
	return $variable; 
}

