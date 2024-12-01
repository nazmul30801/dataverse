<?php

$root_dir = "../";
$page_id = 4;
require $root_dir . "page_handler.php";

if (isset($_GET["id"])) {
    $result = sql_query("SELECT * FROM `caller_id` WHERE `id` = {$_GET["id"]}");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $name = $row["name"];
            $number = $row["number"];
            $connection_id = $row["connectionID"];
        }
        $connection_result = sql_query("SELECT `fullName` FROM `main` WHERE `id` = $connection_id");
        if ($connection_result->num_rows > 0) {
            while ($row = $connection_result->fetch_assoc()) {
                $connection_name = $row["fullName"];
            }
        }
    }
}


$section_contact = <<<HTML
    <section id="contact" class="fs-5">
        <div class="container">
                <div class="card">
                    <div class="card-header text-center fw-bold text-secondary">CONTACT</div>
                    <div class="card-body">
                        <div class="row border-bottom">
                            <div class="col-4">Name</div>
                            <div class="col-8">$name</div>
                        </div>
                        <div class="row border-bottom">
                            <div class="col-4">Number</div>
                            <div class="col-8">$number</div>
                        </div>
                        <div class="connection">Connection with <a href="/identity/index.php?search=$connection_id">$connection_name</a></div>
                    </div>
                    <!-- <div class="card-footer">Footer</div> -->
                </div>
        </div>
    </section>
HTML;








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
        <?php echo $section_contact; ?>
    </main>

    <!-- Body - Footer -->
    <?php require $root_dir . "footer.php"; ?>

    <!-- End Scripts -->
    <?php require $root_dir . "end_scripts.php"; ?>
</body>

</html>