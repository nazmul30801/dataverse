<?php

$root_dir = "";
$page_id = 4;
require $root_dir . "page_handler.php";

$page = page("all");

$alerts = "";
// If submit the Update Form -
if (isset($_POST["submit"]) && isset($_POST["id"])) {
	$id = $_POST["id"];
	
	// Make SQL for update profile
	$form_data = db_col_vs_form_col_array();
	$update_list = "";
	foreach ($form_data as $col) {
		$form_col = isset($_POST[$col[1]]) == True ? $_POST[$col[1]] : "";
		$db_col = $col[0];
		$update_list .= "`$db_col` = '$form_col', ";
	}
	$update_list = substr($update_list, 0, -2);
	$sql = <<<SQL
		UPDATE `main` SET $update_list WHERE `id` = $id
	SQL;

	if (sql_query($sql) === TRUE) {
		$alerts .= make_alert("Data Inserted Successfully", "success");
		$id = $_POST["id"];

		// Profile Photo Upload
		if (isset($_FILES["profileImage"]) && $_FILES["profileImage"]["tmp_name"] != "") {
			$image = $_FILES["profileImage"];
			// print_r($image);
			$target_file = $root_dir . "img/profile/profile_" . $id . ".jpeg";

			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

			// Check if image file is a actual image or fake image
			$check = getimagesize($image["tmp_name"]);
			if ($check !== false) {
				$alerts .= make_alert("File is an image - " . $check["mime"] . ".", "success");
				$uploadOk = 1;
			} else {
				$alerts .= make_alert("File is not an image.", "warning");
				$uploadOk = 0;
			}


			// Check file size
			if ($image["size"] > 500000) {
				$alerts .= make_alert("Sorry, your file is too large.", "warning");
				$uploadOk = 0;
			}

			// Allow certain file formats
			if ($imageFileType == "image/jpeg") {
				$alerts .= make_alert("Sorry, only JPEG files are allowed.", "warning");
				$uploadOk = 0;
			}

			// Check if file already exists
			if (file_exists($target_file)) {
				// Unlink File from path
				if (!unlink($target_file)) {
					// Replace or Create File with new File
					$alerts .= make_alert("Error deleting the file.", "warning");
					$uploadOk = 0;
				}
			}
			if ($uploadOk == 0) {
				$alerts .= make_alert("Sorry, your file was not uploaded.", "warning");
			} else {
				if (move_uploaded_file($image["tmp_name"], $target_file)) {
					$alerts .= make_alert("Image uploaded successfully.", "success");
				} else {
					$alerts .= make_alert("Error creating/replacing the file.", "danger");
				}
			}
		}
		$alerts .= make_alert("Profile Updated Successfully", "success");
		session_start();
		$_SESSION["alerts"] .= $alerts;
		header("Location: {$page["profile"]}?id=$id");
		exit();
	} else {
		$alerts .= make_alert("Profile Updated Failed", "danger");
	}
} elseif (isset($_GET["id"])) {
	$id = $_GET["id"];
	$result = sql_query("SELECT * FROM `main` WHERE `id` = $id");
	if ($result->num_rows == 1) {
		$row = $result->fetch_array();

		if ($row["gender"] == 1) {
			$male_checked = "checked";
			$female_checked = "";
		} else {
			$male_checked = "";
			$female_checked = "checked";
		}

		if ($row["maritalStatus"] == 1) {
			$married_checked = "checked";
			$unmarried_checked = "";
		} else {
			$married_checked = "";
			$unmarried_checked = "checked";
		}

		$add_profile_form = <<<HTML
			<div class="card">
				<div class="card-header h2 p-4 text-bg-success fw-bold">UPDATE PROFILE</div>
				<div class="card-body">
					<form class="row g-3" method="post" action="update-profile.php" enctype="multipart/form-data">
						<!-- Basic Info -->
						<div class="col-12">
							<div class="h4">Basic Info</div>
						</div>
						<div class="col-md-12 d-none">
							<input type="hidden" class="form-control" id="inputID" name="id"
								required readonly placeholder="Dataverse ID"  value="{$row['id']}" />
						</div>
						<div class="col-md-6">
							<input type="text" class="form-control" id="inputFullName" name="full_name"
								required placeholder="Full Name"  value="{$row['name']}" />
						</div>
						<div class="col-md-6">
							<input type="text" class="form-control" id="inputNickName" name="nick_name"
								placeholder="Nick Name"  value="{$row['nickName']}" />
						</div>
						<div class="col-md-6">
							<input type="email" class="form-control" id="inputEmail" name="email"
								placeholder="example@email.com"  value="{$row['email']}" />
						</div>
						<div class="col-md-6">
							<div class="input-group mb-3">
								<input type="text" class="form-control" id="inputNumber"
									name="phone_number" placeholder="+8801987654321" maxlength="14" size="14"  value="{$row['phoneNumber']}" />
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
									placeholder="Present Address - e.g. [1234 Main St]"  value="{$row['presentStreet']}" />
							</div>
						</div>
						<div class="col-xl-4 col-sm-6">
							<div class="input-group mb-3">
								<span class="input-group-text">City</span>
								<input type="text" class="form-control" id="inputCity" placeholder="Dhaka" name="pre_addr_city" value="{$row['presentCity']}" />
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
									placeholder="Present Address - e.g. [1234 Main St]"  value="{$row['street']}" />
							</div>
						</div>
						<div class="col-xl-4 col-sm-6">
							<div class="input-group mb-3">
								<span class="input-group-text">Union</span>
								<input type="text" class="form-control" id="inputUnion" placeholder="Nayergaon Dakkshin" name="union" value="Nayergaon Dakkshin"  value="{$row['_union']}" />
							</div>
						</div>
						<div class="col-xl-4  col-sm-6">
							<div class="input-group mb-3">
								<span class="input-group-text">Sub District</span>
								<input type="text" class="form-control" id="inputSubDist" placeholder="Upazilla/Police Station" name="sub_dist" value="Matlab Dakkshin"  value="{$row['subDistrict']}" />
							</div>
						</div>
						<div class="col-xl-4 col-sm-6">
							<div class="input-group mb-3">
								<span class="input-group-text">District</span>
								<input type="text" class="form-control" id="inputDist" placeholder="Chandpur" name="dist" value="Chanpdur"  value="{$row['district']}" />
							</div>
						</div>
						<div class="col-xl-4 col-sm-6">
							<div class="input-group mb-3">
								<span class="input-group-text">Zip Code</span>
								<input type="number" class="form-control" id="inputZip" placeholder="Zip code" name="zip_code" value="3640"  value="{$row['zip']}" />
							</div>
						</div>
						<div class="col-xl-4  col-sm-6">
							<div class="input-group mb-3">
								<span class="input-group-text">State</span>
								<input type="text" class="form-control" id="inputState" placeholder="Dhaka" name="state" value="Chittagong"  value="{$row['state']}" />
							</div>
						</div>
						<div class="col-xl-4  col-sm-6">
							<div class="input-group mb-3">
								<span class="input-group-text">Country</span>
								<input type="text" class="form-control" id="inputState" placeholder="Dhaka" name="country" value="Bangladesh"  value="{$row['country']}" />
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
									autocomplete="off" required value="1" $male_checked/>
								<label class="btn btn-outline-success" for="male">Male</label>
								<input type="radio" class="btn-check" name="gender" id="female"
									autocomplete="off" required value="0" $female_checked/>
								<label class="btn btn-outline-primary" for="female">Female</label>
							</div>
						</div>
						<div class="col-xl-6">
							<div class="input-group mb-3">
								<span class="input-group-text">Marital Status</span>
								<input type="radio" class="btn-check" id="inputUnmarital"
									name="marital_status" autocomplete="off" required value="0" $unmarried_checked/>
								<label class="btn btn-outline-danger" for="inputUnmarital">Unmarried</label>
								<input type="radio" class="btn-check" id="inputMarried"
									name="marital_status" autocomplete="off" required value="1" $married_checked/>
								<label class="btn btn-outline-success" for="inputMarried">Married</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="input-group mb-3">
								<span class="input-group-text">Spouse ID</span>
								<input type="number" class="form-control" name="spouse_id" placeholder="Dataverse ID"  value="{$row['spouseID']}" />
							</div>
						</div>
						<div class="col-xl-6">
							<div class="input-group mb-3">
								<span class="input-group-text">Education</span>
								<select id="inputEduLvl" class="form-select" name="edu_level">
									<option disabled selected value="{$row['eduLevel']}" >{$row['eduLevel']}</option>
									<option disabled>Select a Level</option>
									<option value="JSC">JSC</option>
									<option value="SSC">SSC</option>
									<option value="HSC">HSC</option>
									<option value="Honours">Honours</option>
									<option value="Masters">Masters</option>
								</select>
								<select id="inputEduGrp" class="form-select" name="edu_group">
									<option disabled selected value="{$row['eduGroup']}" >{$row['eduGroup']}</option>
									<option disabled>Select a Group</option>
									<option value="Science">Science</option>
									<option value="Commerce">Commerce</option>
									<option value="Arts">Arts</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<input type="number" class="form-control" id="inputNid" name="nid"
								maxlength="10" size="10" placeholder="NID Number"  value="{$row['nid']}" />
						</div>
						<div class="col-md-6">
							<div class="input-group mb-3">
								<span class="input-group-text">Date of Birth</span>
								<input class="form-control" id="inputDob" name="dob" type="date"  value="{$row['dob']}" />
							</div>
						</div>
						<div class="col-md-6">
							<input type="text" class="form-control" id="inputOccupation" name="occupation"
								placeholder="Occupation"  value="{$row['occupation']}" />
						</div>
						<div class="col-md-4">
							<select id="inputBloodGroup" class="form-select" name="blood_group">
								<option disabled selected value="{$row['bloodGroup']}" >{$row['bloodGroup']}</option>
								<option disabled>Blood Group</option>
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
								<option disabled selected value="{$row['religion']}" >{$row['religion']}</option>
								<option disabled>Religion</option>
								<option value="Islam">Islam</option>
								<option value="Hindu">Hindu</option>
								<option value="Buddha">Buddha</option>
								<option value="Cristian">Cristian</option>
							</select>
						</div>
						<div class="col-md-4">
							<select id="inputPolilitacView" class="form-select" name="political_view">
								<option disabled selected value="{$row['politicalView']}" >{$row['politicalView']}</option>
								<option disabled>Political View</option>
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
								<input type="number" class="form-control" name="fathers_id" placeholder="Father's Dataverse ID"  value="{$row['fathersID']}" />
							</div>
						</div>
						<div class="col-xl-4  col-sm-6">
							<div class="input-group mb-3">
								<span class="input-group-text">Mother's ID</span>
								<input type="number" class="form-control" name="mothers_id" placeholder="Mother's Dataverse ID"  value="{$row['mothersID']}" />
							</div>
						</div>
						<div class="col-12">
							<div class="h4 mt-5">Social Media Link</div>
						</div>
						<div class="col-12">
							<div class="input-group">
								<span class="input-group-text bg-primary text-white">Facebook</span>
								<input type="text" class="form-control" name="facebook"
									placeholder="https://www.facebook.com/username/"  value="{$row['fb']}" />
							</div>
						</div>
						<div class="col-12">
							<div class="input-group">
								<span class="input-group-text bg-danger text-white">Instagram</span>
								<input type="text" class="form-control" name="instagram"
									placeholder="https://www.instagram.com/username/"  value="{$row['insta']}" />
							</div>
						</div>
						<div class="col-12">
							<div class="input-group">
								<span class="input-group-text bg-dark text-white">Tiktok</span>
								<input type="text" class="form-control" name="tiktok"
									placeholder="https://www.tiktok.com/@username"  value="{$row['tiktok']}" />
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
								id="textAreaAbout">{$row['about']}</textarea>
						</div>
						<!-- Update Buton -->
						<div class="col-12">
							<input class="btn text-bg-success" type="submit" name="submit" value="Update">
						</div>
					</form>
				</div>
			</div>
		HTML;
	} else {
		$alerts .= make_alert("No Profile found for this ID - $id", "danger");
		$add_profile_form = "";
	}
} else {
	$alerts .= make_alert("No Profile Selected for Update", "warning");
	$add_profile_form = "";
}






// --------------------[ HTML Variables ]--------------------

$section_add_profile = <<<HTML
	<section id="inser-form">
		<div class="container py-5">
			<div class="row d-flex justify-content-center align-items-center h-100">
				<div class="col-lg-8">
					$alerts
					$add_profile_form					
				</div>
			</div>
		</div>
	</section>
HTML;

$section_image_cropper = <<<HTML
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
HTML;

$main_sectoin = <<<HTML
	<main>
		$section_add_profile
		$section_image_cropper
	</main>
HTML;

?>





<!DOCTYPE html>
<html lang="en">

<head>
	<link rel="stylesheet" href="assets/custom/css/cropper.min.css">
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
	<script src="assets/custom/js/cropper.min.js"></script>
	<?php echo scripts(); ?>
</body>

</html>