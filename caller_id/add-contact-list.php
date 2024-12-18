<?php

// --------------------[ Header ]--------------------
$root_dir = "../";
$page_id = 1;
require $root_dir . "page_handler.php";




$vcf_input_form = <<<HTML
	<form class="row g-3">
		<div class="col mb-3">
			<label for="id" class="form-label">Profile ID</label>
			<input type="email" id="id" required class="form-control" placeholder="2342">
		</div>
		<label for="vcf_file_input" class="form-label">Select a VCF File</label>
		<div class="col input-group" id="vcf_file_input">
		    <input class="form-control" required type="file" />
			<button type="submit" class="btn btn-primary">Upload</button>
		</div>
	</form>	
HTML;



$sections = <<<HTML
	<section id="vcf_input_section">
		<div class="container">
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