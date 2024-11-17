<?php

// --------------------[ Header ]--------------------
$root_dir = "../";
$page_id = 2;
require $root_dir . "page_handler.php";




// --------------------[ Main ]--------------------
if (isset($_GET["search"])) {
	$query = $_GET["search"];

	$result = sql_query("SELECT * FROM `identity` WHERE `id`=$query");
	if ($result->num_rows > 0) {
		// output data of each row
		while ($row = $result->fetch_assoc()) {
			$id = $row["id"];
			$fullName = $row["fullName"];
			$nickName = $row["nickName"];
			$fullName = $fullName . " " . $nickName;
			$email = $row["email"];
			$phoneNumber = $row["phoneNumber"];
			$preAddrStreet = $row["presentStreet"];
			$preAddrCity = $row["presentCity"];
			$street = $row["street"];
			$union = $row["_union"];
			$subDist = $row["subDistrict"];
			$dist = $row["district"];
			$zipCode = $row["zip"];
			$state = $row["state"];
			$country = $row["country"];

			if ($row["gender"] == 0) {
				$gender = "Female";
			} else {
				$gender = "Male";
			}
			if ($row["maritalStatus"] == 0) {
				$maritalStatus = "Unmarried";
			} else {
				$spouse_result = sql_query("SELECT `fullName`, `nickName` FROM `identity` WHERE `id`=" . $row["spouseID"] . ";");
				if ($spouse_result->num_rows > 0) {
					// output data of each row
					while ($spouse_row = $spouse_result->fetch_assoc()) {
						$spouseName = $spouse_row["fullName"] . " (" . $spouse_row["nickName"].")";
					}
					$maritalStatus = "Married" . '</td></tr> <tr><td>Spouse Name</td><td>' . $spouseName;
				} else {
					$spouseName = "Not Found";
					$maritalStatus = "Married" . '</td></tr> <tr><td></td><td>' . $spouseName;
				}
			}

			$eduLevel = $row["eduLevel"];
			$eduGroup = $row["eduGroup"];
			$nid = $row["nid"];
			$dob = $row["dob"];
			$occupation = $row["occupation"];
			$religion = $row["religion"];
			$politicalView = $row["politicalView"];
			if ($row["fathersID"] === null) {
				$$fathersName = "Not Found";
			} else {
				$fathers_result = sql_query("SELECT `fullName`, `nickName` FROM `identity` WHERE `id`=" . $row["fathersID"] . ";");
				if ($fathers_result->num_rows > 0) {
					// output data of each row
					while ($fathers_row = $fathers_result->fetch_assoc()) {
						$fathersName = $fathers_row["fullName"] . " (" . $fathers_row["nickName"].")";
					}
				} else {
					$fathersName = "Not Found";
				}
			}
			if ($row["mothersID"] === null) {
				$mothersName = "Not Found";
			} else {
				$mothers_result = sql_query("SELECT `fullName`, `nickName` FROM `identity` WHERE `id`=" . $row["mothersID"] . ";");
				if ($mothers_result->num_rows > 0) {
					// output data of each row
					while ($mothers_row = $mothers_result->fetch_assoc()) {
						$mothersName = $mothers_row["fullName"] . " (" . $mothers_row["nickName"].")";
					}
				} else {
					$mothersName = "Not Found";
				}
			}
			$about = $row["about"];
			$fb = $row["fb"];
			$insta = $row["insta"];
			$tiktok = $row["tiktok"];
		}
		$profile_section =
			'<section id="profile" class="h-100 bg-light">
			<div class="container pt-2 h-100">
				<div class="row d-flex justify-content-center h-100">
					<div class="col-lg-3 col-md-4 ">
						<div class="row">
							<div class="col-sm-12 mt-3">
								<form role="search" method="get">
									<div class="input-group mb-3">
										<input class="form-control" type="search" placeholder="Search" aria-label="Search" name="search" value="'.$query.'" />
										<button class="btn btn-success" type="submit">Search</button>
									</div>
								</form>
							</div>
							<div class="col-sm-12 my-3">
								<div class="card bg-success">
									<div class="card-img-top d-flex justify-content-center p-3">
										<img onerror="this.src=\'' . $root_dir . 'img/profile/profile_demo.jpeg\';" src="' . $root_dir . 'img/profile/profile_' . $id . '.jpeg" class="rounded-circle border border-light border-5 w-100" style="max-height:300px; max-width:300px;">
									</div>
									<div class="card-body">
										<h5 class="card-title fs-4 capitalize-text fw-bold text-center text-white">' . $fullName . '</h5>
									</div>
								</div>
							</div>
							<div class="col-sm-12 my-3">
								<div class="card">
									<div class="card-header bg-success fw-bold text-white text-center">Online Accounts</div>
									<ul class="list-group list-group-flush text-center">
										<li class="list-group-item"><a target=”_blank” href="' . $fb . '" class="btn btn-outline-primary"><i class="bi bi-facebook"></i> Facebook</a></li>
										<li class="list-group-item"><a target=”_blank” href="' . $insta . '" class="btn btn-outline-info"><i class="bi bi-instagram"></i> Instagram</a></li>
										<li class="list-group-item"><a target=”_blank” href="' . $tiktok . '" class="btn btn-outline-danger"><i class="bi bi-tiktok"></i> Tiktok</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-9 col-md-8 my-3">
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
									<div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
										<table class="table table-hover">
											<tbody>
											<tr><td class="fw-bold">Dataverse ID</td><td>' . $id . '</td></tr>
												<tr><td>Full Name</td><td>' . $fullName . '</td></tr>
												<tr><td>Email</td><td>' . $email . '</td></tr>
												<tr><td>Phone Number</td><td>' . $phoneNumber . '</td></tr>
												<tr><td>Date of Birth</td><td>' . $dob . '</td></tr>
												<tr><td>Nationanl ID</td><td>' . $nid . '</td></tr>
												<tr><td>Gender</td><td>' . $gender . '</td></tr>
												<tr><td>Marital Status</td><td>' . $maritalStatus . '</td></tr>
												<tr><td>Education Level</td><td>' . $eduLevel . '</td></tr>
												<tr><td>Education Group</td><td>' . $eduGroup . '</td></tr>
												<tr><td>Occupation</td><td>' . $occupation . '</td></tr>
												<tr><td>Religion</td><td>' . $religion . '</td></tr>
												<tr><td>Political View</td><td>' . $politicalView . '</td></tr>
											</tbody>
										</table>
									</div>
									<div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
										<table class="table table-hover">
											<tbody>
												<tr><th>Present Address</th></tr>
												<tr><td>' . $preAddrStreet . ', ' . $preAddrCity . '</td></tr>
											</tbody>
										</table><table class="table table-hover">
											<tbody>
												<tr><th colspan="2">Parmanent Address</th></tr>
												<tr><td>Street</td><td>' . $street . '</td></tr>
												<tr><td>Union</td><td>' . $union . '</td></tr>
												<tr><td>Thana, Sub-District</td><td>' . $subDist . '</td></tr>
												<tr><td>District</td><td>' . $dist . '</td></tr>
												<tr><td>Zip Code</td><td>' . $zipCode . '</td></tr>
												<tr><td>State</td><td>' . $state . '</td></tr>
												<tr><td>Country</td><td>' . $country . '</td></tr>
											</tbody>
										</table>
									</div>
									<div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="tab2-tab">
										<table class="table table-hover">
											<tbody>
												<tr><td>Fathers Name</td><td>' . $fathersName . '</td></tr>
												<tr><td>Mothers Name</td><td>' . $mothersName . '</td></tr>
											</tbody>
										</table>
									</div>
									<pre class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab3-tab">' . $about . '</pre>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>';
	} else {
		$profile_section =
			'<section id="profile" class="h-100 bg-light">
			<div class="container py-5 h-100">
				<div class="row d-flex justify-content-center h-100">
					<div class="col-12 m-sm-5 p-sm-5">
						<div class="display-2 text-secondary text-center">No Profile Found</div>
					</div><div class="col-12 m-sm-5 p-sm-5">
						<form class="d-flex" role="search" method="get">
							<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="q" />
							<button class="btn btn-outline-success" type="submit">Search</button>
						</form>
					</div>
				</div>
			</div>
		</section>';
	}
} else {
	$profile_section =
		'<section id="profile" class="h-100 bg-light">
			<div class="container py-5 h-100">
				<div class="row d-flex justify-content-center h-100">
					<div class="col-12 m-sm-5 p-sm-5">
						<div class="display-2 text-secondary text-center mb-sm-0 mb-5">Identity</div>
					</div><div class="col-12 m-sm-5 p-sm-5">
						<form class="d-flex" role="search" method="get">
							<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search" />
							<button class="btn btn-outline-success" type="submit">Search</button>
						</form>
					</div>
				</div>
			</div>
		</section>';
}






?>



<!DOCTYPE html>
<html lang="en">

<head>
	<?php require $root_dir . "meta_links.php"; ?>
	<title><?php echo $title; ?></title>
</head>

<body>
	<!-- Body - Header -->
	<?php require $root_dir . "header.php"; ?>

	<!-- Main Body  -->
	<main>
		<?php echo $profile_section; ?>
	</main>

	<!-- Body - Footer -->
	<?php require $root_dir . "footer.php"; ?>

	<!-- Script -->
	<?php require $root_dir . "end_scripts.php"; ?>
</body>

</html>