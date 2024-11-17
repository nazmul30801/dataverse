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
        <section id="apps-list">
            <div class="container p-5 d-flex justify-content-center">
                <div class="app-box">
                    <div class="app-box-title display-1">Apps</div>
                    <div class="app-box-body d-flex flex-wrap justify-content-center">
                        <a href="/identity" class="app">Identity</a>
                        <a href="/caller_id/" class="app">Caller ID</a>
                        <a href="/shekor/" class="app">Shekor</a>
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