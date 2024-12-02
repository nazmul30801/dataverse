<?php

// --------------------[ Header ]--------------------
$root_dir = "";
$page_id = 1;
require $root_dir . "page_handler.php";








$sections = "Content goes here";
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