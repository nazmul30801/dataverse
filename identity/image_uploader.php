<?php
session_start();
$id = $_SESSION["id"];
$imageFile = $_SESSION["imageFile"];

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="/css/cropper.min.css">
    <?php require "../meta_links.php"; ?>
    <title>Dataverse</title>
</head>

<body>
    <!-- Body - Header -->
    <?php require "../header.php"; ?>

    <!-- Main Body  -->
    <main>

        <!-- Image Corpper Section -->
        <section id="imageCropperSection" class="container">
            <div class="row d-flex justify-content-center align-content-center">
                <div class="col-lg-6">
                    <div class="frame">
                        <img src="<?php echo $imageFile; ?>" id="image">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="frame bg-success p-5">
                        <img src="" id="output" class="rounded-circle border border-light border-5">
                    </div>
                    <button type="button" class="btn btn-success mt-3" id="cropBtn">Crop Image</button>
                </div>
            </div>
        </section>
    </main>

    <!-- Body - Footer -->
    <?php require "../footer.php"; ?>

    <!-- Script -->
    <script src="/js/cropper.min.js"></script>
    <script>
        document.getElementById("output")
    </script>

    <?php require "../end_scripts.php"; ?>
</body>

</html>