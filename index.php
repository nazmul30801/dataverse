<?php

$root_dir = "";
$page_id = 1;
require $root_dir . "page_handler.php";

$search_engine =  search_engine();
$section_search_engine = <<<HTML
    <section id="search_engine">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="display-1 py-5 text-center text-secondary"><img class="d-inline-block" style="width: 18rem;" src="/img/text-logo.png" alt=""></div>
                </div>
                <div class="col-12">
                    <div class="search-bar">
                        $search_engine
                    </div>
                </div>
            </div>
        </div>
    </section>
HTML;

$section_app_list = <<<HTML
    <section id="apps-list">
        <div class="container">
            <div class="card app-box">
                <div class=" d-flex flex-wrap justify-content-center">
                    <a href="{$page['caller_id']}" class="app border"><i class="fa-solid fa-address-book"></i></a>
                    <a href="{$page['shekor']}" class="app border"><i class="fa-solid fa-people-roof"></i></a>
                    <a href="{$page['add-profile']}" class="app border"><i class="fa-solid fa-square-plus"></i></i></a>
                </div>
            </div>
        </div>
    </section>
HTML;

$main_sectoin = <<<HTML
    <main>
        $section_search_engine
        $section_app_list
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