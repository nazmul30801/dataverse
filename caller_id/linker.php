<?php

$root_dir = "../";
$page_id = 4;
require $root_dir . "page_handler.php";

$alerts = "";
$name = "";
$number = "";
$relative = "";
$contact_profile_id = "";
if (isset($_GET["submit"])) {
	$mode = "search";
	$name = $_GET["name"];
	$number = $_GET["number"];
	if (isset($_GET["relative"])) {
		$relative = $_GET["relative"];
	} else {
		$relative = "all";
	}
} elseif (isset($_POST["link"])) {
	$mode = "link";

	$contact_profile_id = $_POST["profileID"];
	if ($contact_profile_id == 0) {
		$alerts = make_alert("Profile ID is Required", "Danger");
		$mode = "none";
	}

	// Filter caller_id_ keys
	$caller_ids = array_filter($_POST, function ($key) {
		return strpos($key, 'caller_id_') === 0;
	}, ARRAY_FILTER_USE_KEY);
	// Get the values for the filtered keys
	$caller_ids = array_values($caller_ids);
	// Convert array to comma-separated string
	$caller_ids_str = implode(", ", $caller_ids);

	$sql = "UPDATE `caller_id` SET `profileID` = '$contact_profile_id' WHERE `id`  IN ($caller_ids_str);";

	// echo $sql;
	if (sql_query($sql)) {
		// Filter numbers keys
		$numbers = array_filter($_POST, function ($key) {
			return strpos($key, 'number_') === 0;
		}, ARRAY_FILTER_USE_KEY);
		// Get the values for the filtered keys
		$numbers = array_values($numbers);
		// Removes Duplicate Numbers
		$numbers = array_unique($numbers);
		// Convert array to comma-separated string
		$numbers_str = implode(", ", $numbers);

		$sql1 = "UPDATE `caller_id` SET `profileID` = '$contact_profile_id' WHERE `number`  IN ($numbers_str);";
		// echo $sql1;
		if (sql_query($sql1)) {

			$alerts .= make_alert("Profile Linked Successfully", "success");
			$name = "";
		} else {
			$alerts .= make_alert("Profile Linking Failed", "danger");
		}
	}
} else {
	$mode = "none";
}


// ---------------------[ Collect Profile List ]---------------------

$result = sql_query("SELECT DISTINCT `connectionID` FROM `caller_id`;");
if ($result->num_rows > 0) {
	// id to name convertion

	// Connection ID List
	$connection_id_list = "";
	while ($row = $result->fetch_assoc()) {
		$connection_id_list .= $row["connectionID"] . ", ";
	}
	$connection_id_list = substr($connection_id_list, 0, -2);


	$name_list = sql_query("SELECT `id`, `name` FROM `main` WHERE id IN ($connection_id_list);");

	$id_name_table = [];
	$options = <<<HTML
			<option value="all">All</option>
		HTML;
	$option1 = "";
	while ($row = $name_list->fetch_assoc()) {
		$id_name_table += [$row["id"] => $row["name"]];
		$options .= <<<HTML
			<option value="{$row['id']}">{$row["name"]}</option>
		HTML;
	}

	if ($relative == "all") {
		$select_state = "";
		$option1 = '<option value="all" selected>All</option>';
	} elseif ($relative == "") {
		$select_state = "selected";
		$option1 = '';
	} elseif ($relative != "all") {
		$select_state = "";
		$option1 .= <<<HTML
			<option value="$relative" selected>$id_name_table[$relative]</option>
		HTML;
	} else {
		$select_state = "selected";;
		$option1 = "";
	}
} else {
	$options = "<option value='none' disabled selected>No Relative Found</option>";
}


$options = <<<HTML
	<option value="none" $select_state disabled>Select a Relative</option>
	$option1
	$options
HTML;








// ---------------------[ Making Conditions ]---------------------

$number_condition = make_condition($number, "number");
$name_condition = make_condition($name, "name");
if ($relative == "all") {
	$relative_condition = "";
} else {
	$relative_condition = make_condition($relative, "connectionID");
}
$condition = "1" . $number_condition . $name_condition . $relative_condition;
if ($condition == "1" and $relative == "all") {
	$condition = "1";
} elseif ($condition == "1") {
	$condition = "0";
}




// ---------------------[ Data Collecton ]---------------------
if ($mode == "link") {
	$contact_result = sql_query("SELECT * FROM `caller_id` WHERE `profileID` = $contact_profile_id ;");
} elseif ($mode == "search") {
	$contact_result = sql_query("SELECT * FROM `caller_id` WHERE $condition;");
}

$total_result = 0;
if (isset($contact_result)) {
	if ($contact_result->num_rows > 0) {
		$total_result = $contact_result->num_rows;
		$table_data = "";
		$caller_ids = "";
		$x = 0;
		while ($row = $contact_result->fetch_assoc()) {
			// Contact Profile Data
			$contact_profile_id = $row["profileID"];
			if ($contact_profile_id == 0) {
				$contact_profile_name = "Not Linked";
				$contact_profile_link = "#";
			} else {
				
				$contact_profile_name = get_cell("SELECT `name` FROM `main` WHERE `id` = $contact_profile_id;");
				$contact_profile_name .= " ($contact_profile_id)";
				$contact_profile_link = profile_link($contact_profile_id);
			}
			// Connection Profile Data
			$connection_profile_link = profile_link($row["connectionID"]);
			$contact_name = contact_link($row["id"], $row["name"]);
			// $contact_number = contact_link($row["id"], $row["number"]);
			$caller_id = $row["id"];
			$caller_ids .= $caller_id . ", ";
			$table_data .= <<<HTML
			<tr>
				<td>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" onchange="toggle('number_$x')" name="caller_id_$x" value="$caller_id" id="flexCheckDefault"  />
					</div>
					<input class="form-check-input d-none" type="checkbox" name="number_$x" value="{$row['number']}" id="number_$x"/>
				</td>
				<td>$caller_id</td>
				<td>$contact_name</td>
				<td>{$row["number"]}</td>
				<td>
					<a
					class = "text-decoration-none fw-bold text-secondary" 
					href="$connection_profile_link">{$id_name_table[$row["connectionID"]]}</a>
				</td>
				<td>
					<a
					class = "text-decoration-none fw-bold text-purple" 
					href="$contact_profile_link">$contact_profile_name</a>
				</td>
			</tr>
			HTML;
			$x++;
		}
		
		$search_reesult_body = <<<HTML
		<form id="search_form" class="row g-3 mb-3" method="post" enctype="multipart/form-data" action="linker.php">
			<div class="input-group flex-nowrap">
				<!-- <span class="input-group-text" id="addon-wrapping">Caller IDs</span>
				<input type="text" class="form-control" placeholder="234, 23, 2344, 2341, ...." name="callerIDs" value="$caller_ids" /> -->
				<span class="input-group-text" id="addon-wrapping">Profile ID</span>
				<input type="text" class="form-control" style="max-width: 75px" placeholder="234556" name="profileID" value="$contact_profile_id" />
				<input class="btn btn-primary" type="submit" name="link" value="Link" />
			</div>
			<table class="table table-hover">
				<thead class="table-success">
					<tr>
						<th>
							<div class="form-check">
								<input class="form-check-input" id="select_all" type="checkbox" value="" id="flexCheckDefault" />
							</div>
						</th>
						<th>ID</th>
						<th>Name</th>
						<th>Number</th>
						<th>Connection with</th>
						<th>Profile</th>
					</tr>
				</thead>
				<tbody class="data-sheet-body">
					$table_data
				</tbody>
			</table>
		</form>
		HTML;
	} else {
		$search_reesult_body = <<<HTML
		<div class="fs-5 text-center fw-bold text-secondary py-5">
			<i class="fa-solid fa-circle-xmark"></i> No Contact Found
		</div>
	HTML;
	}
} else {
	$search_reesult_body = <<<HTML
	<div class="fs-5 text-center fw-bold text-secondary py-5">
		<i class="fa-solid fa-circle-xmark"></i> No Contact Found
	</div>
HTML;
}



$search_box = <<<HTML
	<div id="search_box">
		<div class="card">
			<div class="card-header fw-bold text-secondary">Search Box</div>
			<div class="card-body">
				<form id="search_form" class="row g-3" method="get" enctype="multipart/form-data">
					<div>
						<input class="form-control" type="number" name="number" placeholder="01x xxxx-xxxx" value=$number>
					</div>
					<div>
						<input class="form-control" type="text" name="name" placeholder="Name here..." value="$name">
					</div>
					<div>
						<select name="relative" class="form-control">
							$options
						</select>
					</div>
					<div>
						<button class="btn btn-outline-danger" onclick="document.getElementById('search_form').reset();">Reset</button>
						<input class="btn btn-success float-end" name="submit" type="submit" value="Search">
					</div>
				</form>
			</div>
		</div>
	</div>
HTML;

$search_result = <<<HTML
	<div id="search_result">
		<div class="card">
			<div class="card-header fw-bold text-secondary">
				Contact List
				<span class="float-end">$total_result Result Found</span>
			</div>
			<div class="card-body table-responsive">
				$search_reesult_body
			</div>
		</div>
	</div>
HTML;

$alerts .= get_session_var("alerts");
$section_caller_id = <<<HTML
	<section id="caller_id">
		<div class="container">
			$alerts
			<div class="row">
				<div class="col-lg-4">$search_box</div>
				<div class="col-lg-8">$search_result</div>
			</div>
		</div>
	</section>
HTML;

$main_sectoin = <<<HTML
	<main>
		$section_caller_id
	</main>
HTML;

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php echo meta_links(); ?>
	<title><?php echo $title; ?></title>
</head>

<body>
	<!-- Body - Header -->
	<?php echo page_header(); ?>

	<!-- Main Body  -->
	<?php echo $main_sectoin; ?>

	<!-- Body - Footer -->
	<?php echo page_footer(); ?>

	<!-- End Scripts -->
	<?php echo scripts(); ?>
	<script>
		document.getElementById('select_all').addEventListener('change', function() {
			var checkboxes = document.querySelectorAll('.data-sheet-body .form-check-input[type="checkbox"]');
			for (var checkbox of checkboxes) {
				checkbox.checked = this.checked;
			}
		});
		function toggle(html_id) {
			document.getElementById(html_id).checked = !document.getElementById(html_id).checked;
		}
	</script>
</body>

</html>