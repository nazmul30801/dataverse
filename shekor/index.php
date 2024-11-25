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
    $result = sql_query("SELECT `id`, `fathersID`, `fullName` FROM `main` WHERE id = " . $dads_id . ";");
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
$family = array();
$result = sql_query("SELECT * FROM `main` WHERE fathersID = " . $own["id"] . " ORDER BY id ASC;");
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        if ($row["gender"] == 0) {
            $row["Gender"] = "ছেলে";
        } else {
            $row["Gender"] = "মেয়ে";
        }
        $family[] = $row;
    }
    // HTML Formating
    $family_table_head =
        '<table class="table table-striped">
                <tr>
                    <th>ID</th>
                    <th>নাম</th>
                    <th>পদবি</th>
                </tr>';
    $family_table_rows = "";
    foreach ($family as $family_member) {
        $table_row =
            "<tr>
                <td>" . $family_member["id"] . "</td>
                <td><a href='?id=" . $family_member["id"] . "'>" . $family_member["fullName"] . "</a></td>
                <td>" . $family_member["Gender"] . "</td>
            </tr>";
        $family_table_rows .= $table_row;
    }
    $family_table = $family_table_head . $family_table_rows . "</table>";
} else {
    $family_table = '<div class="error-title">' . $own["fullName"] . ' এর পরিবারের কোনো তথ্য পাওয়া যায় নি</div>';
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php require $root_dir . "meta_links.php"; ?>
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <title><?php echo $title; ?></title>
</head>

<body>
    <!-- Body - Header -->
    <?php require $root_dir . "header.php"; ?>

    <!-- Main Body  -->
    <main>
        <section id="generation-series">
            <div class="container">
                <div class="text-white"><span class="fw-bold">বংশানুক্রম :</span>
                    <?php
                    foreach ($gen_series as $gen_member) {
                        echo "<a href='?id=" . $gen_member["id"] . ";'>" . $gen_member["fullName"] . "</a> <span>></span>";
                    }
                    ?>
                </div>
            </div>
        </section>
        <section id="family">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="family-head">
                            <div class="card">
                                <div class="card-header">পরিবারের প্রধান</div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $own["fullName"] . " (ID - " . $own["id"] . ")"; ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="family-member">
                            <div class="card">
                                <div class="card-header">পরিবারের সদস্যগন</div>
                                <div class="card-body">
                                    <?php echo $family_table; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Body - Footer -->
    <?php require $root_dir . "footer.php"; ?>

    <!-- End Scripts -->
    <?php require $root_dir . "end_scripts.php"; ?>
</body>

</html>