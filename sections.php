<?php
require "function.php";
function meta_links()
{
	$meta_links = <<<HTML
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon" />
		<link rel="stylesheet" href="/assets/fontawesome/css/all.min.css">
		<link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="/assets/custom/css/style.css" />
	HTML;
	return $meta_links;
}

function scripts()
{
	$script = <<<HTML
		<script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="/assets/custom/js/script.js"></script>
	HTML;
	return $script;
}

	

function menu() {
	$add_profile = "/add-profile.php";
	$caller_id = "/caller_id/index.php";
	$shekor = "/shekor/index.php";
	$search_engine = search_engine();

	return <<<HTML
		<nav id="main_menu" class="navbar navbar-expand-lg bg-light border-bottom">
			<div class="container-fluid">
				<a class="navbar-brand" href="/">
					<img src="/img/logo.png" style="height:30px"/>
				</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse"
					data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
					aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav me-auto mb-2 mb-lg-0">
						<li class="nav-item">
							<a class="nav-link" aria-current="page" href="$add_profile">Profile +</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" aria-current="page" href="$caller_id">Caller ID</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" aria-current="page" href="$shekor">Shekor</a>
						</li>
					</ul>
					$search_engine
				</div>
			</div>
		</nav>
	HTML;
}



function page_header() {
	$menu = menu();
	return <<<HTML
		<header>
			<!-- Nav Bar -->
			$menu
		</header>
	HTML;
}

function page_footer() {
    return <<<HTML
        <footer class="border-top">
            <div class="container">
                <div id="copyright">
                    Copyright © 2025 | <span class="fw-bold">MD NAZMUL HAQUE</span> | All Right Reserved
                </div>
            </div>
        </footer>
    HTML;
}



function search_engine($query = "")
{
	$search_engine = <<<HTML
		<form action="/search.php" role="search" method="get">
			<div class="input-group">
				<input type="search" class="form-control" required placeholder="Search here ..." name="search" value="$query">
				<button class="btn btn-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
			</div>
		</form>
	HTML;
	return $search_engine;
}

function full_search_engine($query = "")
{
	$search_engine = search_engine($query);
	$full_search_engine = <<<HTML
		<section id="full_search_engine">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="search-bar">
								<?php echo search_engine($query); ?>
							</div>
						</div>
				</div>
			</div>
		</section>
	HTML;
	return $full_search_engine;
}


function main_section_header($title)
{
	$main_section_header = <<<HTML
		<section id="profile">
			<div class="container my-5">
				<div class="row">
					<div class="col-12">
						<div class="display-1 text-success fw-bold text-center text-secondary">
							<div><i class="fa-solid fa-address-card"></i> $title</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	HTML;
	return $main_section_header;
}


function search_item($link, $id, $name, $details)
{
	$search_item = <<<HTML
		<a href="$link$id" class="result_item border-bottom">
			<div class="row">
				<div class="col-md-2 col-3 d-flex align-items-center">
					<div class="profile-image">
						<img onerror="this.src='/img/profile/profile_demo.jpeg';" src="/img/profile/profile_{$id}.jpeg">
					</div>
				</div>
				<div class="col-md-10 col-9 d-flex align-items-center">
					<div class="row w-100">
						<div class="col-md-4 col-12">
							<div class="profile-name fw-bold">$name</div>
						</div>
						<div class="col-md-6 col-12 mt-md-0 mt-2">
							$details
						</div>
					</div>
				</div>
			</div>
		</a>
	HTML;
	return $search_item;
}

function profile_link($id) {
	return "/profile.php?id=$id\" class\"profile-link\"";
}
function linked_profile($id, $link_value) {
	$link = profile_link($id);
	return "<a href=\"$link\">$link_value</a>";
}


function full_name($row) {
	if ($row["nickName"] != "") {
		$full_name = "{$row["name"]} ({$row["nickName"]})";
	} else {
		$full_name = $row["name"];
	}
	return $full_name;
}


function make_alert($text) {
	return <<<HTML
		<div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
			$text <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	HTML;
}



function db_col_vs_form_col_array() {
	$form_data = array(
		array("name", "full_name"),
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
		array("spouseID", "spouse_id"),
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
	return $form_data;
}