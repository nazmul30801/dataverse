<?php 

$root_dir = "";
$page_id = "home";



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <?php require "meta_links.php"; ?>
    <title><?php echo $title; ?></title>
</head>

<body>
    <!-- Body - Header -->
    <?php require $root_dir."header.php"; ?>

    <!-- Main Body  -->
    <?php require $root_dir."main.php"; ?>

    <!-- Body - Footer -->
    <?php require $root_dir."footer.php"; ?>

    <!-- End Scripts -->
    <?php require $root_dir."end_scripts.php"; ?>
</body>

</html>