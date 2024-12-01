<?php

// --------------------[ Header ]--------------------
$root_dir = "";
$page_id = 2;
require $root_dir . "page_handler.php";




// --------------------[ Main ]--------------------
$section_search_result = "";
$section_search_result_status = 0;
$search_item_all = "";


if (isset($_GET["search"]) && $_GET["search"] != "") {
    $query = $_GET["search"];

    $columns = ["id", "fullName"];
    $link = "/profile.php?id=";
    $result = sql_query(make_sql($query, "main", $columns));
    $result_number = $result->num_rows;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $details = <<<HTML
                <div class='search-details'>
                    <span class=''>{$row["column_name"]} : </span>{$row["value"]}
                </div>
            HTML;
            $search_item_all .= search_item($link, $row[$columns[0]], $row[$columns[1]],  $details);
        }
        // }

        // $columns = ["id", "name"];
        // $link = "/caller_id/contact.php?id=";
        // $result = sql_query(make_sql($query, "caller_id", $columns));
        // $result_number += $result->num_rows;
        // if ($result->num_rows > 0) {
        //     while ($row = $result->fetch_assoc()) {
        //         $details = <<<HTML
        //             <div class='search-details'>
        //                 <span class=''>{$row["column_name"]} : </span>{$row["value"]}
        //             </div>
        //         HTML;
        //         $search_item_all .= search_item($link, $row[$columns[0]], $row[$columns[1]],  $details);
        //     }
    } else {
        $search_item_all = <<<HTML
            <div class="fs-5 text-center fw-bold text-secondary">
                <i class="fa-solid fa-circle-xmark"></i> No Data Found
            </div>
        HTML;
    }
    $section_search_result_status = 1;
} else {
    $query = "";
}

$section_search_result = <<<HTML
    <section id="search_result">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="d-inline-Block float-start">Search Result</div>
                    <div class="d-inline-Block float-end">$result_number Result Found</div>
                </div>
                <div class="card-body">
                    $search_item_all
                </div>
            </div>
        </div>
    </section>
HTML;
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
                        <div class="search-bar">
                            <?php echo search_engine($query); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php view_section($section_search_result, $section_search_result_status) ?>
    </main>

    <!-- Body - Footer -->
    <?php require $root_dir . "footer.php"; ?>

    <!-- End Scripts -->
    <?php require $root_dir . "end_scripts.php"; ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            highlightSpecifiedText('search-details', '<?php echo $query; ?>');
        });
    </script>
</body>

</html>