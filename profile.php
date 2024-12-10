<?php

// --------------------[ Header ]--------------------
$root_dir = "";
$page_id = 2;
require $root_dir . "page_handler.php";
$page = page("all");



// --------------------[ Main ]--------------------
if (isset($_GET["id"])) {
	$query = $_GET["id"];

	// ----------[ All Data Collection ]----------
	$search_engine = search_engine($query);
	$result = sql_query("SELECT * FROM `main` WHERE `id`=$query");
	if ($result->num_rows > 0) {
		// output data of each row
		while ($row = $result->fetch_assoc()) {

			// ----------[ Basic Data Collection ]----------
			$id = $row["id"];
			$name = $row["name"];
			$nick_name = $row["nickName"];
			$full_name = full_name($row);
			$email = $row["email"];
			$phoneNumber = $row["phoneNumber"];

			// ----------[ Address Data Collection ]----------
			$preAddrStreet = $row["presentStreet"];
			$preAddrCity = $row["presentCity"];
			$street = $row["street"];
			$union = $row["_union"];
			$subDist = $row["subDistrict"];
			$dist = $row["district"];
			$zipCode = $row["zip"];
			$state = $row["state"];
			$country = $row["country"];

			// ----------[ Gender Data Collection ]----------
			if ($row["gender"] == 0) {
				$spouse_property_name = "Husband";
				$gender = "Female";
			} else {
				$spouse_property_name = "Wife";
				$gender = "Male";
			}

			// ----------[ Marital Status Data Collection ]----------
			if ($row["maritalStatus"] == 0) {
				$marital_status_row = "<tr><td>Marital Status</td><td>Unmarried</td></tr>";
			} else {
				$marital_status_row = "<tr><td>Marital Status</td><td>Married</td></tr>";
			}

			$spouse_result = sql_query("SELECT `name`, `nickName` FROM `main` WHERE `id`=" . $row["spouseID"] . ";");
			if ($spouse_result->num_rows == 1) {
				$spouse_row = $spouse_result->fetch_array();
				$spouse_name = full_name($spouse_row);
				$spouse_name = linked_profile($row["spouseID"], $spouse_name);
				$spouse_name_row = "<tr><td>$spouse_property_name</td><td>$spouse_name</td></tr>";
			} else {
				$spouse_name_row = "";
			}


			// ----------[ Work Data Collection ]----------
			$eduLevel = $row["eduLevel"];
			$eduGroup = $row["eduGroup"];
			$nid = $row["nid"];
			$dob = $row["dob"];
			$blood_group = $row["bloodGroup"];
			$occupation = $row["occupation"];
			$religion = $row["religion"];
			$politicalView = $row["politicalView"];

			// ----------[ Fother Data Collection ]----------
			if ($row["fathersID"] === null) {
				$fathers_name_row = "";
			} else {
				$fathers_result = sql_query("SELECT `name`, `nickName` FROM `main` WHERE `id`=" . $row["fathersID"] . ";");
				if ($fathers_result->num_rows > 0) {
					$fathers_row = $fathers_result->fetch_array();
					$fathers_name = full_name($fathers_row);
					$fathers_name = linked_profile($row["fathersID"], $fathers_name);
					$fathers_name_row = "<tr><td>Fathers Name</td><td>$fathers_name</td></tr>";
				} else {
					$fathers_name_row = "";
				}
			}

			// ----------[ Mother Data Collection ]----------
			if ($row["mothersID"] === null) {
				$mothers_name_row = "";
			} else {
				$mothers_result = sql_query("SELECT `name`, `nickName` FROM `main` WHERE `id`=" . $row["mothersID"] . ";");
				if ($mothers_result->num_rows > 0) {
					$mothers_row = $mothers_result->fetch_array();
					$mothers_name = full_name($mothers_row);
					$mothers_name = linked_profile($row["mothersID"], $mothers_name);
					$mothers_name_row = "<tr><td>Mothers Name</td><td>$mothers_name</td></tr>";
				} else {
					$mothers_name_row = "";
				}
			}

			// ----------[ Others Data Collection ]----------
			$about = $row["about"];
			$fb = $row["fb"];
			$insta = $row["insta"];
			$tiktok = $row["tiktok"];
		}




		$alerts = get_session_var("alerts");
		$profile_header = <<<HTML
			$alerts
			<div class="card bg-light">
				<div class="card-body">
					<div class="row">
						<div class="col-sm-3">
							<div class="profile-image d-flex align-items-sm-end justify-content-sm-start justify-content-center">
								<img
								onerror="this.src='{$root_dir}img/profile/profile_demo.jpeg';"
								src="{$root_dir}img/profile/profile_{$id}.jpeg"
								class="rounded-circle border border-success border-3 w-100"
								style="max-height: 150px; max-width: 150px"
								/>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="profile-name d-flex align-items-sm-center justify-content-sm-start justify-content-center">
								<div class="fs-4 fw-bold text-secondary text-sm-start text-center">$full_name</div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="profile-buttons d-flex align-items-sm-end justify-content-sm-end justify-content-center">
								<a class="btn btn-success fw-bold" href="{$page['update-profile']}?id=$id"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		HTML;

		$profile_own_data = <<<HTML
			<div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
				<table class="table table-hover">
					<tbody>
					<tr><td class="fw-bold">Dataverse ID</td><td>$id</td></tr>
						<tr><td>Email</td><td>$email</td></tr>
						<tr><td>Phone Number</td><td>$phoneNumber</td></tr>
						<tr><td>Date of Birth</td><td>$dob</td></tr>
						<tr><td>Nationanl ID</td><td>$nid</td></tr>
						<tr><td>Blood Group</td><td>$blood_group</td></tr>
						<tr><td>Gender</td><td>$gender</td></tr>
						$marital_status_row
						<tr><td>Education Level</td><td>$eduLevel</td></tr>
						<tr><td>Education Group</td><td>$eduGroup</td></tr>
						<tr><td>Occupation</td><td>$occupation</td></tr>
						<tr><td>Religion</td><td>$religion</td></tr>
						<tr><td>Political View</td><td>$politicalView</td></tr>
						<tr>
							<td>Social Media</td>
							<td class="social-buttons">
								<a target=”_blank” href="$fb" class="btn btn-primary"><i class="fa-brands fa-facebook-f"></i> Facebook</a>
								<a target=”_blank” href="$insta" class="btn btn-info"><i class="fa-brands fa-instagram"></i> Instagram</a>
								<a target=”_blank” href="$tiktok" class="btn btn-danger"><i class="fa-brands fa-tiktok"></i> Tiktok</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		HTML;

		$profile_address_data = <<<HTML
			<div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
				<table class="table table-hover">
					<tbody>
						<tr><th>Present Address</th></tr>
						<tr><td>$preAddrStreet, $preAddrCity</td></tr>
					</tbody>
				</table>
				<table class="table table-hover">
					<tbody>
						<tr><th colspan="2">Parmanent Address</th></tr>
						<tr><td>Street</td><td>$street</td></tr>
						<tr><td>Union</td><td>$union</td></tr>
						<tr><td>Thana, Sub-District</td><td>$subDist</td></tr>
						<tr><td>District</td><td>$dist</td></tr>
						<tr><td>Zip Code</td><td>$zipCode</td></tr>
						<tr><td>State</td><td>$state</td></tr>
						<tr><td>Country</td><td>$country</td></tr>
					</tbody>
				</table>
			</div>
		HTML;

		$profile_family_data = <<<HTML
			<div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="tab2-tab">
				<table class="table table-hover">
					<tbody>
						$fathers_name_row
						$mothers_name_row
						$spouse_name_row
					</tbody>
				</table>
			</div>
		HTML;

		$profile_others_data = <<<HTML
			<pre class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab3-tab">$about</pre>
		HTML;

		$profile_body = <<<HTML
			<div class="card">
				<div class="card-header bg-light">
					<ul class="nav nav-tabs card-header-tabs" id="myTab"
						role="tablist">
						<li class="nav-item">
							<a class="nav-link active text-dark" id="tab1-tab"
								data-bs-toggle="tab"
								href="#tab1" role="tab"
								aria-controls="tab1" aria-selected="true">
								Own Data
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link text-dark" id="tab2-tab"
								data-bs-toggle="tab" href="#tab2" role="tab"
								aria-controls="tab2" aria-selected="false">
								Address
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link text-dark" id="tab2-tab"
								data-bs-toggle="tab" href="#tab3" role="tab"
								aria-controls="tab3" aria-selected="false">
								Family Info
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link text-dark" id="tab3-tab"
								data-bs-toggle="tab" href="#tab4" role="tab"
								aria-controls="tab4" aria-selected="false">
								Others Data
							</a>
						</li>
					</ul>
				</div>
				<div class="card-body">
					<div class="tab-content" id="myTabContent">
						$profile_own_data
						$profile_address_data
						$profile_family_data
						$profile_others_data
					</div>
				</div>
			</div>
		HTML;

		$section_profile = <<<HTML
			<section id="profile">
				<div class="container">
					<div class="row">
						<div class="col-12">
							$profile_header
						</div>
						<div class="col-12">
							$profile_body
						</div>
					</div>
				</div>
			</section>
		HTML;
	} else {
		$full_search_engine = full_search_engine();
		$section_profile = <<<HTML
			<section id="search_engine">
				$full_search_engine
			</section>
		HTML;
	}
} else {
	$full_search_engine = full_search_engine();
	$section_profile = <<<HTML
		<section id="search_engine">
			$full_search_engine
		</section>
	HTML;
}


$main_sectoin = <<<HTML
	<main>
		$section_profile
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
</body>

</html>