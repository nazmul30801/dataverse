<?php


// --------------------[ Header ]--------------------
$root_dir = "../";
$page_id = 3;
require $root_dir . "page_handler.php";






if (!isset($_GET["id"])) {
    $_GET["id"] = "1";
}
$cid = $_GET["id"];





// ------------------[ Own Data ]------------------
$result = sql_query("SELECT * FROM `main` WHERE id = " . $cid . ";");
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $own = $row;
        $gen_series = array($row);
    }
} else {
    echo "0 results - Own Data";
}

// ------------------[ Gen Series Data ]------------------
$dads_id = $own["fathersID"];
while ($dads_id != 0) {
    $result = sql_query("SELECT `id`, `fathersID`, `name` FROM `main` WHERE id = " . $dads_id . ";");
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $dads_id = $row["fathersID"];
            $gen_series[] = $row;
        }
    } else {
        echo "0 results gen";
    }
}
$gen_series = array_reverse($gen_series);




// ------------------[ Family Data ]------------------
if ($own["gender"] == 0) {
    $result = sql_query("SELECT * FROM `main` WHERE mothersID = " . $own["id"] . " ORDER BY id ASC;");
} else {
    $result = sql_query("SELECT * FROM `main` WHERE fathersID = " . $own["id"] . " ORDER BY id ASC;");
}
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        if ($row["gender"] == 0) {
            $row["Gender"] = "মেয়ে";
        } else {
            $row["Gender"] = "ছেলে";
        }
        $family[] = $row;
    }
    
    // HTML Formating
    $family_table_head =<<<HTML
        <tr>
            <th>ID</th>
            <th>নাম</th>
            <th>পদবি</th>
        </tr>
    HTML;

    $family_table_rows = "";
    foreach ($family as $family_member) {
        $family_member_name = full_name($family_member);
        $family_member_name = "<a href=\"?id={$family_member["id"]}\">$family_member_name</a>";
        $family_table_rows .= <<<HTML
            <tr>
                <td>{$family_member["id"]}</td>
                <td>$family_member_name</a></td>
                <td>{$family_member["Gender"]}</td>
            </tr>

        HTML;
    }

    $family_table = <<<HTML
        <table class="table table-hover">
            $family_table_head
            $family_table_rows
        </table>
    HTML;

} else {

    if ($own["gender"] == 0) {
        $fid = $own["spouseID"];
        $mid = $cid;
    } else {
        $fid = $cid;
        $mid = $own["spouseID"];
    }
    $link = "/add-profile.php?fathers_id=$fid&mothers_id=$mid";
    $family_table = <<<HTML
        <p class="card-text">{$own["name"]} এর পরিবারে কোনো সদস্য পাওয়া যায় নি।</p>
        <a href="$link" class="btn btn-success">Add Family Member</a>
    HTML;
    // $family_table = '<div class="error-title">' . $own["name"] . ' এর পরিবারের কোনো তথ্য পাওয়া যায় নি</div>';
}


$gen_members = "";
foreach ($gen_series as $gen_member) {
    $gen_memeber_name = "<a href=\"?id={$gen_member["id"]}\">{$gen_member["name"]}</a>";
    $gen_members .= "$gen_memeber_name <span>></span>";
}

$section_generation_series = <<<HTML
    <section id="generation-series">
        <div class="container">
            <div class="text-white"><span class="fw-bold">বংশানুক্রম :</span>
                $gen_members
            </div>
        </div>
    </section>
HTML;

$link = profile_link($own["id"]);
$section_family = <<<HTML
    <section id="family">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="family-head">
                        <div class="card">
                            <div class="card-header">পরিবারের প্রধান</div>
                            <div class="card-body">
                                <div class="name fw-bold fs-4 text-center">
                                    <a class="text-decoration-none text-secondary text-hover-warning" href="$link">{$own["name"]}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="family-member">
                        <div class="card">
                            <div class="card-header">পরিবারের সদস্যগন</div>
                            <div class="card-body">
                                $family_table
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
HTML;

$main_sectoin = <<<HTML
    <main>
        $section_generation_series
        $section_family
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