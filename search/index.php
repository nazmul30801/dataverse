<?php

// --------------------[ Header ]--------------------
$root_dir = "../";
$page_id = 2;
require $root_dir . "page_handler.php";




// --------------------[ Main ]--------------------
function search_item()
{
    $search_item = <<<HTML
        <a href="#" class="result_item border-bottom">
            <div class="row">
                <div class="col-md-2 col-3 d-flex align-items-center">
                    <div class="profile-image">
                        <img src="/img/profile/profile_78.jpeg">
                    </div>
                </div>
                <div class="col-md-10 col-9">
                    <div class="row">
                        <div class="col-md-4 col-12 d-flex align-items-center">
                            <div class="profile-name fw-bold fs-5">Anisur Rahman</div>
                        </div>
                        <div class="col-md-6 col-12 mt-2">
                            <p>Thisi is a text for demo to this correctly</p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    HTML;
    return $search_item;
}



if (isset($_GET["search"])) {
    $query = $_GET["search"];

    $sql = "";



    $sql = "SELECT ";
} else {
    $query = "";
}


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
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="display-1 py-5 text-center text-secondary"><img class="d-inline-block" style="width: 18rem;" src="/img/text-logo.png" alt=""></div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex justify-content-center py-3">
                            <div class="w-75">
                                <?php echo search_engine($query); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="search_result">
            <div class="container">
                <div class="search-result-box border">
                    <?php
                    $i = 1;
                    while ($i <= 10) {
                        echo search_item();
                        $i += 1;
                    }
                    ?>
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