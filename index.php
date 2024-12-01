<?php

$root_dir = "";
$page_id = 1;
require $root_dir . "page_handler.php";


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
        <section id="search_engine">
            <div class="container py-5">
                <div class="row">
                    <div class="col-12">
                        <div class="display-1 pb-5 text-center text-secondary"><img class="d-inline-block" style="width: 18rem;" src="/img/text-logo.png" alt=""></div>
                    </div>
                    <div class="col-12">
                        <div class="search-bar my-5">
                            <?php echo search_engine(); ?>
                        </div>
                    </div>
                </div>
        </section>
        <section id="apps-list">
            <div class="container">
                <div class="row">
                </div>
                <div class="col-12">
                    <div class="app-box d-flex justify-content-center ">
                        <div class="app-box-body bg-secondary d-flex flex-wrap justify-content-center">
                            <!-- <a href="/identity" class="app"><i class="fa-solid fa-address-card"></i></a> -->
                            <a href="/caller_id/" class="app"><i class="fa-solid fa-address-book"></i></a>
                            <a href="/shekor/" class="app"><i class="fa-solid fa-people-roof"></i></a>
                            <a href="/identity/insert.php" class="app"><i class="fa-solid fa-square-plus"></i></i></a>
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