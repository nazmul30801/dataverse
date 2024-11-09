<!DOCTYPE html>
<html lang="en">

<head>
    <?php require "meta_links.php"; ?>
    <title>Dataverse</title>
    <style>
        .container {
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        hr {
            margin: 4rem 0;
            background-color: #5e5e5e;
        }

        .logo {
            display: block;
            width: 40rem;
        }

        .text {
            font-family: monospace;
            font-size: 2rem;
            text-align: center;
            padding: 5rem 1rem;
            background-color: #e6e6e6;
            border-radius: 2rem;
            color: #f00;
            box-shadow: inset #7f7f7fa1 2px 2px 10px 0;
        }
    </style>
</head>

<body>
    <!-- Body - Header -->
    <?php require "header.php"; ?>

    <!-- Main Body  -->
    <main>
        <div class="container">
            <div class="display">
                <img class="logo" src="/img/text-logo.png" alt="Dataverse">
                <hr>
                <div class="text">Site is under construct</div>
            </div>
        </div>
    </main>

    <!-- Body - Footer -->
    <?php require "footer.php"; ?>

    <!-- End Scripts -->
    <?php require "end_scripts.php"; ?>
</body>

</html>