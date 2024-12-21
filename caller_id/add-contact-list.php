<?php

// --------------------[ Header ]--------------------
$root_dir = "../";
$page_id = 1;
require $root_dir . "page_handler.php";


// --------------------[ Main Code ]--------------------
$alerts = "";
if (isset($_POST['submit'])) {
	$id = $_POST['id'];
	$vcf_file = $_FILES['vcf_file'];
	$vcf_file_name = $vcf_file['name'];
	$vcf_file_tmp_name = $vcf_file['tmp_name'];
	$vcf_file_size = $vcf_file['size'];
	$vcf_file_error = $vcf_file['error'];
	$vcf_file_type = $vcf_file['type'];
	$file_ext = explode('.', $vcf_file_name);
	$file_actual_ext = strtolower(end($file_ext));
	$allowed = array('vcf');

	if (in_array($file_actual_ext, $allowed)) {
		if ($vcf_file_error === 0) {
			if ($vcf_file_size < 1000000) {
				$vcf_file_name_new = "profile_" . $id . "_contacts.vcf";
				$vcf_file_destination = $root_dir . '/caller_id/vcf/' . $vcf_file_name_new;
				if (move_uploaded_file($vcf_file_tmp_name, $vcf_file_destination)) {
					// Add Contact List
					$contacts = get_contacts($vcf_file_destination);
					$sql = "INSERT INTO `caller_id` (`id`, `name`, `number`, `connectionID`) VALUES";
					foreach ($contacts as $contact) {
						$name = $contact['name'];
						$number = $contact['number'];
						$sql .= " (NULL, '$name', '$number', '$id'),";
					}
					$sql = substr($sql, 0, -1) . ";";
					if (sql_query($sql)) {
						$alerts .= make_alert("Contact list added successfully.", "success");
						session_start();
						$_SESSION["alerts"] .= $alerts;
						header("Location: index.php?number=&name=&relative=$id&submit=Search");
					} else {
						$alerts .= make_alert("Failed to add contacts.", "danger");
					}
				} else {
					$alerts .= make_alert("Failed to upload file.", "danger");
				}
			} else {
				$alerts .= make_alert("File size is too large.", "danger");
			}
		} else {
			$alerts .= make_alert("There was an error uploading your file.", "danger");
		}
	} else {
		$alerts .= make_alert("You cannot upload this type of files.", "warning");
	}
}


// --------------------[ HTML Part ]--------------------
$vcf_input_form = <<<HTML
	<form class="row g-3" action="add-contact-list.php" method="POST" enctype="multipart/form-data">
		<div class="col-12 mb-3">
			<label for="id_input" class="form-label">Profile ID</label>
			<input type="number" id="id_input" name="id" required class="form-control" placeholder="2342">
		</div>
		<div class="col-12 mb-3">
			<label for="vcf_file_input" class="form-label">Select a VCF File</label>
			<div class="input-group">
				<input class="form-control" id="vcf_file_input" required type="file" name="vcf_file" accept=".vcf"/>
				<input type="submit" class="btn btn-primary" name="submit" value="Upload" />
			</div>
		</div>
	</form>	
HTML;



$sections = <<<HTML
	<section id="vcf_input_section">
		<div class="container">
			$alerts
			<div class="card">
				<div class="card-header">Add Contact List</div>
				<div class="card-body">
					$vcf_input_form
				</div>
			</div>
		</div>
	</section>
HTML;
$main_sectoin = <<<HTML
    <main>
        $sections
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