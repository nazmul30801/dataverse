<?php

$base_dir = "../";
$error = array();
$insert_status_html = "";
if (isset($_POST["submit"])) {

	$form_data = array(
		array("fullName", "full_name"),
		array("nickName", "nick_name"),
		array("email", "email"),
		array("phoneNumber", "phone_number"),
		array("presentStreet", "pre_addr_street"),
		array("presentCity", "pre_addr_city"),
		array("street", "street"),
		array("_union", "union"),
		array("subDistrict", "sub_dist"),
		array("district", "dist"),
		array("zip", "zip_code"),
		array("state", "state"),
		array("country", "country"),
		array("gender", "gender"),
		array("maritalStatus", "marital_status"),
		array("eduLevel", "edu_level"),
		array("eduGroup", "edu_group"),
		array("nid", "nid"),
		array("dob", "dob"),
		array("bloodGroup", "blood_group"),
		array("occupation", "occupation"),
		array("religion", "religion"),
		array("politicalView", "political_view"),
		array("fathersID", "fathers_id"),
		array("mothersID", "mothers_id"),
		array("fb", "facebook"),
		array("insta", "instagram"),
		array("tiktok", "tiktok"),
		array("about", "about")
	);

	$db_cols = "`id`";
	$form_cols = "NULL";
	foreach ($form_data as $col) {
		$form_col = isset($_POST[$col[1]]) == True ? $_POST[$col[1]] : "";
		$db_cols .= ", `" . $col[0] . "`";
		$form_cols .= ",'" . $form_col . "'";
	}
	$sql = "INSERT INTO `identity` (" . $db_cols . ") VALUES (" . $form_cols . ");";


	require $base_dir . "dbhandler.php";
	if ($conn->query($sql) === TRUE) {
		if (isset($_FILES["profileImage"])) {
			$image = $_FILES["profileImage"];


			$last_id = $conn->insert_id;
			$target_file = $base_dir . "img/profile/profile_" . $last_id . ".jpeg";


			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

			// Check if image file is a actual image or fake image
			$check = getimagesize($image["tmp_name"]);
			if ($check !== false) {
				$error[] = "File is an image - " . $check["mime"] . ".";
				$uploadOk = 1;
			} else {
				$error[] = "File is not an image.";
				$uploadOk = 0;
			}


			// Check if file already exists
			if (file_exists($target_file)) {
				$error[] = "Sorry, file already exists.";
				$uploadOk = 0;
			}

			// Check file size
			if ($image["size"] > 500000) {
				$error[] = "Sorry, your file is too large.";
				$uploadOk = 0;
			}

			// Allow certain file formats
			if ($imageFileType == "image/jpeg") {
				$error[] = "Sorry, only JPEG files are allowed.";
				$uploadOk = 0;
			}

			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				$error[] = "Sorry, your file was not uploaded.";
				// if everything is ok, try to upload file
			} else {
				if (move_uploaded_file($image["tmp_name"], $target_file)) {
					$error[] = "The file " . htmlspecialchars(basename($image["name"])) . " has been uploaded.";

					// session_start();
					// $_SESSION["id"] = $conn->insert_id;
					// $_SESSION["imageFile"] = $target_file;
					// header("Location: image_uploader.php");
				} else {
					$error[] = "Sorry, there was an error uploading your file.";
				}
			}

			$insert_status = [
				"color" => "success",
				"text_bold" => "Data Inserted Successfully",
				"text_normal" => ""
			];
		}
	} else {
		$insert_status = [
			"color" => "danger",
			"text_bold" => "Error: " . $sql,
			"text_normal" => $conn->error
		];
	}


	$conn->close();

	foreach ($error as $err) {
		$insert_status_html .= '<div class="alert alert-info alert-dismissible fade show" role="alert">
<strong></strong>' . $err . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
	}


	$insert_status_html .= '<div class="alert alert-' . $insert_status['color'] . ' alert-dismissible fade show" role="alert">
<strong>' . $insert_status['text_bold'] . '</strong>' . $insert_status['text_normal'] . '
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';

	$insert_status_html .= '<div class="alert alert-primary alert-dismissible fade show" role="alert">
	New Profile ID - '.$last_id.' <a href="/identity/index.php?q='.$last_id.'"><strong>View</strong></a>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
} else {

	$insert_status_html = "";
}



?>








<!DOCTYPE html>
<html lang="en">

<head>
	<link rel="stylesheet" href="/css/cropper.min.css">
	<?php require $base_dir . "meta_links.php"; ?>
	<title>Dataverse</title>
</head>

<body>
	<!-- Body - Header -->
	<?php require $base_dir . "header.php"; ?>

	<!-- Main Body  -->
	<main>
		<!-- page Update -->
		<!-- <section id="page-update" class="bg-light">
            <div class="container">
                
            </div>
        </section> -->

		<!-- Insert Form Section -->
		<section id="inser-form" class="h-100 bg-light">
			<div class="container py-5 h-100">
				<div class="row d-flex justify-content-center align-items-center h-100">
					<div class="col-lg-8">
						<?php echo $insert_status_html; ?>
						<div class="card">
							<div class="card-header h2 p-4 text-bg-success">Insert Form</div>
							<div class="card-body">
								<form class="row g-3" method="post" action="insert.php" enctype="multipart/form-data">






									<!-- Basic Info -->
									<div class="col-12">
										<div class="h4">Basic Info</div>
									</div>
									<div class="col-md-6">
										<input type="text" class="form-control" id="inputFullName" name="full_name"
											required placeholder="Full Name" />
									</div>
									<div class="col-md-6">
										<input type="text" class="form-control" id="inputNickName" name="nick_name"
											placeholder="Nick Name" />
									</div>
									<div class="col-md-6">
										<input type="email" class="form-control" id="inputEmail" name="email"
											placeholder="example@email.com" />
									</div>
									<div class="col-md-6">
										<div class="input-group mb-3">
											<span class="input-group-text" id="basic-addon1">Tel</span>
											<span>
												<select id="inputCountryCode" class="form-select" name="country_code">
													<option value="+880" selected>+880</option>
													<option value="+39">+39</option>
													<option value="+39">+39</option>
												</select>
											</span>
											<input type="number" class="form-control" id="inputNumber"
												name="phone_number" placeholder="1987654321" maxlength="10" size="10" />
										</div>
									</div>










									<!-- Addresses -->
									<div class="col-12">
										<div class="h4 mt-5">Addresses</div>
									</div>


									<!-- Present Address -->
									<div class="col-12">
										<div class="h5 mt-3">Present Addresses</div>
									</div>
									<div class="col-xl-8 col-md-12">
										<div class="input-group mb-3">
											<span class="input-group-text">Street</span>
											<input type="text" class="form-control" id="inputPresentAddress"
												name="pre_addr_street"
												placeholder="Present Address - e.g. [1234 Main St]" />
										</div>
									</div>
									<div class="col-xl-4 col-sm-6">
										<div class="input-group mb-3">
											<span class="input-group-text">City</span>
											<input type="text" class="form-control" id="inputCity" placeholder="Dhaka" name="pre_addr_city" value="Chandpur" />
										</div>
									</div>


									<!-- Parmanent Address -->
									<div class="col-12">
										<div class="h5 mt-3">Parmanent Addresses</div>
									</div>
									<div class="col-xl-8">
										<div class="input-group mb-3">
											<span class="input-group-text">Street</span>
											<input type="text" class="form-control" id="inputPresentAddress"
												name="street" value="House- Boro Bari, Vill- Panchgharia"
												placeholder="Present Address - e.g. [1234 Main St]" />
										</div>
									</div>
									<div class="col-xl-4 col-sm-6">
										<div class="input-group mb-3">
											<span class="input-group-text">Union</span>
											<input type="text" class="form-control" id="inputUnion" placeholder="Nayergaon (S:)" name="union" value="Nayergaon (S:)" />
										</div>
									</div>
									<div class="col-xl-4  col-sm-6">
										<div class="input-group mb-3">
											<span class="input-group-text">Sub District</span>
											<input type="text" class="form-control" id="inputSubDist" placeholder="Upazilla/Police Station" name="sub_dist" value="Matlab" />
										</div>
									</div>
									<div class="col-xl-4 col-sm-6">
										<div class="input-group mb-3">
											<span class="input-group-text">District</span>
											<input type="text" class="form-control" id="inputDist" placeholder="Chandpur" name="dist" value="Chanpdur" />
										</div>
									</div>
									<div class="col-xl-4 col-sm-6">
										<div class="input-group mb-3">
											<span class="input-group-text">Zip Code</span>
											<input type="number" class="form-control" id="inputZip" placeholder="Zip code" name="zip_code" value="3640" />
										</div>
									</div>
									<div class="col-xl-4  col-sm-6">
										<div class="input-group mb-3">
											<span class="input-group-text">State</span>
											<input type="text" class="form-control" id="inputState" placeholder="Dhaka" name="state" value="Chittagong" />
										</div>
									</div>
									<div class="col-xl-4  col-sm-6">
										<div class="input-group mb-3">
											<span class="input-group-text">Country</span>
											<input type="text" class="form-control" id="inputState" placeholder="Dhaka" name="country" value="Bangladesh" />
										</div>
									</div>





									<!-- Others Info -->
									<div class="col-12">
										<div class="h4 mt-5">Others Info</div>
									</div>
									<div class="col-xl-6">
										<div class="input-group mb-3">
											<span class="input-group-text">Gender</span>
											<input type="radio" class="btn-check" name="gender" id="male"
												autocomplete="off" required value="1" />
											<label class="btn btn-outline-success" for="male">Male</label>
											<input type="radio" class="btn-check" name="gender" id="female"
												autocomplete="off" required value="0" />
											<label class="btn btn-outline-primary" for="female">Female</label>
										</div>
									</div>
									<div class="col-xl-6">
										<div class="input-group mb-3">
											<span class="input-group-text">Marital Status</span>
											<input type="radio" class="btn-check" id="inputUnmarital"
												name="marital_status" autocomplete="off" required value="0" />
											<label class="btn btn-outline-danger" for="inputUnmarital">Unmarried</label>
											<input type="radio" class="btn-check" id="inputMarried"
												name="marital_status" autocomplete="off" required value="1" />
											<label class="btn btn-outline-success" for="inputMarried">Married</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="input-group mb-3">
											<span class="input-group-text">Spouse ID</span>
											<input type="text" class="form-control" name="spouseDID" placeholder="Dataverse ID" />
										</div>
									</div>
									<div class="col-xl-6">
										<div class="input-group mb-3">
											<span class="input-group-text">Education</span>
											<select id="inputEduLvl" class="form-select" name="edu_level">
												<option disabled selected value=None>Level</option>
												<option value="JSC">JSC</option>
												<option value="SSC">SSC</option>
												<option value="HSC">HSC</option>
												<option value="Honours">Honours</option>
												<option value="Masters">Masters</option>
											</select>
											<select id="inputEduGrp" class="form-select" name="edu_group">
												<option disabled selected value=None>Group</option>
												<option value="Science">Science</option>
												<option value="Commerce">Commerce</option>
												<option value="Arts">Arts</option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<input type="number" class="form-control" id="inputNid" name="nid"
											maxlength="10" size="10" placeholder="NID Number" />
									</div>
									<div class="col-md-6">
										<div class="input-group mb-3">
											<span class="input-group-text">Date of Birth</span>
											<input class="form-control" id="inputDob" name="dob" type="date" />
										</div>
									</div>
									<div class="col-md-6">
										<input type="text" class="form-control" id="inputOccupation" name="occupation"
											placeholder="Occupation" />
									</div>
									<div class="col-md-4">
										<select id="inputBloodGroup" class="form-select" name="blood_group">
											<option disabled selected value=None>Blood Group</option>
											<option value="A+">A+</option>
											<option value="A-">A-</option>
											<option value="B+">B+</option>
											<option value="B-">B-</option>
											<option value="AB+">AB+</option>
											<option value="AB-">AB-</option>
											<option value="O+">O+</option>
											<option value="O-">O-</option>
										</select>
									</div>
									<div class="col-md-4">
										<select id="inputReligion" class="form-select" name="religion">
											<option disabled selected value=None>Religion</option>
											<option value="Islam">Islam</option>
											<option value="Hindu">Hindu</option>
											<option value="Buddha">Buddha</option>
											<option value="Cristian">Cristian</option>
										</select>
									</div>
									<div class="col-md-4">
										<select id="inputPolilitacView" class="form-select" name="political_view">
											<option disabled selected value=None>Political View</option>
											<option value="None">None</option>
											<option value="Awamileague">Awamileague</option>
											<option value="BNP">BNP</option>
											<option value="Jatiya Party">Jatiya Party</option>
											<option value="Jamaate Islami">Jamaate Islami</option>
										</select>
									</div>





									<!-- Family Info -->
									<div class="col-12">
										<div class="h4 mt-5">Family Info</div>
									</div>
									<div class="col-xl-4  col-sm-6">
										<div class="input-group mb-3">
											<span class="input-group-text">Father's ID</span>
											<input type="text" class="form-control" name="fathers_id" placeholder="Father's Dataverse ID" />
										</div>
									</div>
									<div class="col-xl-4  col-sm-6">
										<div class="input-group mb-3">
											<span class="input-group-text">Mother's ID</span>
											<input type="text" class="form-control" name="mothers_id" placeholder="Mother's Dataverse ID" />
										</div>
									</div>
									<div class="col-12">
										<div class="h4 mt-5">Social Media Link</div>
									</div>
									<div class="col-12">
										<div class="input-group">
											<span class="input-group-text bg-primary text-white">Facebook</span>
											<input type="text" class="form-control" name="facebook"
												placeholder="https://www.facebook.com/username/" />
										</div>
									</div>
									<div class="col-12">
										<div class="input-group">
											<span class="input-group-text bg-danger text-white">Instagram</span>
											<input type="text" class="form-control" name="instagram"
												placeholder="https://www.instagram.com/username/" />
										</div>
									</div>
									<div class="col-12">
										<div class="input-group">
											<span class="input-group-text bg-dark text-white">Tiktok</span>
											<input type="text" class="form-control" name="tiktok"
												placeholder="https://www.tiktok.com/@username" />
										</div>
									</div>
									<div class="col-12">
										<div class="h4 mt-5">Profile Photo</div>
									</div>
									<div class="col-12">
										<div class="mb-3">
											<input class="form-control" type="file" id="imageToUpload" name="profileImage">
										</div>
									</div>
									<div class="col-12">
										<div class="h4 mt-5">About</div>
									</div>
									<div class="col-12">
										<textarea class="form-control" name="about" rows="5"
											id="textAreaAbout"></textarea>
									</div>




									<!-- Save Buton -->
									<div class="col-12">
										<input class="btn text-bg-success" type="submit" name="submit" value="Insert">
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Image Cropper Modal -->
		<section class="modal m-0 p-0" id="imageCropperModal" tabindex="100">
			<div class="modal-dialog modal-fullscreen">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Modal title</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="container">
							<div class="row">
								<div class="col-lg-6">
									<div class="frame" id="inputImageFrame">
										<img id="editImage">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="frame bg-success" id="outputImageFrame">
										<img id="outputImage" class="rounded-circle border border-light border-5">
									</div>
								</div>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" id="cropBtn">Crop Image</button>
						<button type="button" class="btn btn-primary" id="saveBtn">Save</button>
					</div>
				</div>
			</div>
		</section>
	</main>

	<!-- Body - Footer -->
	<footer></footer>

	<!-- Script -->
	<script src="/js/cropper.min.js"></script>
	<?php require $base_dir . "end_scripts.php"; ?>
</body>

</html>