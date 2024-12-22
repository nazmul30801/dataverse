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

// function get($data_column, $sql = "SELECT * FROM `main` WHERE `id` = 34;")
function get_cell($sql = "SELECT * FROM `main` WHERE `id` = 34;")
{
	if ($result = sql_query($sql)) {
		if ($result->num_rows > 0) {
			$row = $result->fetch_row();
			$cell_data = $row[0];
		} else {
			$cell_data = null;
		}
		return $cell_data;
	} else {
		return "SQL Error";
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
function fix_tel($number)
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


//  specific session variable remover 
function get_session_var($variable_name)
{
	session_start();
	if (isset($_SESSION[$variable_name])) {
		$variable = $_SESSION[$variable_name];
		unset($_SESSION[$variable_name]);
	} else {
		$variable = "";
	}
	return $variable;
}



// VCF File to Array
function get_contacts($file_path)
{
	$vcf_contents = file_get_contents($file_path);

	if ($vcf_contents === false) {
		echo "Failed to read the VCF file.";
		return [];
	}

	$contacts = [];
	$vcards = explode("BEGIN:VCARD", $vcf_contents);

	foreach ($vcards as $vcard) {
		if (trim($vcard) == "") continue;

		$name = "Unknown";
		$number = null;

		// Match FN field (Full Name)
		if (preg_match('/FN(;CHARSET=UTF-8;ENCODING=QUOTED-PRINTABLE)?:([^\n]+)/', $vcard, $name_matches)) {
			$name = trim($name_matches[2]);
			if (isset($name_matches[1])) {
				$name = quoted_printable_decode($name);
			}
			// Remove unwanted characters from the name
			$name = preg_replace('/[\\\\;\'"]/u', '', $name);
		}
		$name = str_replace('.', ' ', $name);

		// Match TEL field (Telephone Number)
		if (preg_match('/TEL(;[^:]+)?:([^\n]+)/', $vcard, $number_matches)) {
			$number = trim($number_matches[2]);
		} else {
			// Try to match TEL field without attributes
			if (preg_match('/TEL:([^\n]+)/', $vcard, $number_matches)) {
				$number = trim($number_matches[1]);
			}
		}

		// Clean up the phone number by removing non-numeric characters and adding country code
		if ($number) {
			// Remove non-numeric characters
			$number = preg_replace('/[^0-9]/', '', $number);
			$number = fix_tel($number);
		}

		// Only add contact if number is present and valid
		if ($number) {
			$contacts[] = ['name' => $name, 'number' => $number];
		}
	}

	return $contacts;
}
