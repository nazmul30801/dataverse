<?php

$root_dir = "../";
$page_id = 4;
require $root_dir . "page_handler.php";

if (isset($_GET["id"]) && $_GET["id"] != "") {
    $result = sql_query("SELECT * FROM `caller_id` WHERE `id` = {$_GET["id"]}");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $name = $row["name"];
            $number = $row["number"];
            $connection_id = $row["connectionID"];
        }
        $connection_result = sql_query("SELECT `name` FROM `main` WHERE `id` = $connection_id");
        if ($connection_result->num_rows > 0) {
            while ($row = $connection_result->fetch_assoc()) {
                $connection_name = $row["name"];
            }
        }
    }
    $connection_profile = linked_profile($connection_id, $connection_name);
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
                    <div class="connection">Connection with $connection_profile</div>
                </div>
                <!-- <div class="card-footer">Footer</div> -->
            </div>
        </div>
    </section>
    HTML;
} else {
    $section_contact = <<<HTML
    <section id="contact" class="fs-5">
        <div class="container">
            <div class="card">
                <div class="card-header text-center fw-bold text-secondary">CONTACT</div>
                <div class="card-body">
                    <div class="text-center fw-bold text-secondary py-3">Select a Contact form Caller ID</div>
                    <form class="row-cols-lg-auto g-3 align-items-center p-3">
                        <div class="col-12">
                            <label class="visually-hidden" for="inlineFormInputGroupUsername">Username</label>
                            <div class="input-group">
                                <input type="text" name="id" class="form-control"  placeholder="Contact ID"/>
                                <input type="submit" class="btn btn-primary" value="Go"/>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- <div class="card-footer">Footer</div> -->
            </div>
        </div>
    </section>
    HTML;
}






$main_sectoin = <<<HTML
    <main>
        $section_contact
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