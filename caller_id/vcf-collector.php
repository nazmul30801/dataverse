<?php
include "function.php";

if (isset($_FILES["fileToUpload"]) and isset($_POST["name"])) {
    $fileOnForm = $_FILES["fileToUpload"];
    $personName = $_POST["name"];
    $fileOnServer = "uploads/vcf/" . $personName . "'s Contacts.vcf";
    if (upload($fileOnForm, $fileOnServer)) {
        if (insert_contacts($fileOnServer, $personName)) {
            header("Location: index.php?number=&name=&relative=".$personName);
        } else {
            $status = "<li>Unable to Insert Data</li>";
        }
    } else {
        $status .= "<li>Unable to upload file !</li>";
    }
    $status = "<ul>$status</ul>";

} else {
    $status = "<h3>Upload a VCF File</h3>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Contacts</title>
</head>

<body>
    <header>
        <div class="site-title">Contacts</div>
    </header>
    <section class="nav-section">
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">VCF Collector</a></li>
                <li><a href="demo.php">Demo</a></li>
                <li><a href="uploads/">Uploads</a></li>
            </ul>
        </nav>
    </section>
    <section class="main-section">
        <section class="search-box">
            <form class="search-form" method="post" enctype="multipart/form-data">
                <div class="search-form-header">Upload your Contacts</div>
                <div class="search-form-body">
                    <input type="file" name="fileToUpload">
                    <input name="name" type="text" placeholder="Your Name...">
                    <input type="submit" value="Upload">
                </div>
            </form>
            <div class="upload-status"><?php echo $Status; ?></div>
        </section>
    </section>
</body>

</html>