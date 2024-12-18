<?php

$root_dir = "../";
$page_id = 4;
require $root_dir . "page_handler.php";


if (isset($_GET["submit"])) {
    $name = $_GET["name"];
    $number = $_GET["number"];
    if (isset($_GET["relative"])) {
        $relative = $_GET["relative"];
    } else {
        $relative = "all";
    }
} else {
    $name = "";
    $number = "";
    $relative = "";
}



// ---------------------[ Collect Profile List ]---------------------

$result = sql_query("SELECT DISTINCT `connectionID` FROM `caller_id`;");
if ($result->num_rows > 0) {
    // id to name convertion

    // Connection ID List
    $connection_id_list = "";
    while ($row = $result->fetch_assoc()) {
        $connection_id_list .= $row["connectionID"] . ", ";
    }
    $connection_id_list = substr($connection_id_list, 0, -2);


    $name_list = sql_query("SELECT `id`, `name` FROM `main` WHERE id IN ($connection_id_list);");

    $id_name_table = [];
    $options = <<<HTML
            <option value="all">All</option>
        HTML;
    $option1 = "";
    while ($row = $name_list->fetch_assoc()) {
        $id_name_table += [$row["id"] => $row["name"]];
        $options .= <<<HTML
            <option value="{$row['id']}">{$row["name"]}</option>
        HTML;
    }

    if ($relative == "all") {
        $select_state = "";
        $option1 = '<option value="all" selected>All</option>';
    } elseif ($relative == "") {
        $select_state = "selected";
        $option1 = '';
    } elseif ($relative != "all") {
        $select_state = "";
        $option1 .= <<<HTML
            <option value="$relative" selected>$id_name_table[$relative]</option>
        HTML;
    } else {
        $select_state = "selected";;
        $option1 = "";
    }
} else {
    $options = "<option value='none' disabled selected>No Relative Found</option>";
}


$options = <<<HTML
    <option value="none" $select_state disabled>Select a Relative</option>
    $option1
    $options
HTML;








// ---------------------[ Making Conditions ]---------------------

$number_condition = make_condition($number, "number");
$name_condition = make_condition($name, "name");
if ($relative == "all") {
    $relative_condition = "";
} else {
    $relative_condition = make_condition($relative, "connectionID");
}
$condition = "1" . $number_condition . $name_condition . $relative_condition;
if ($condition == "1" and $relative == "all") {
    $condition = "1";
} elseif ($condition == "1") {
    $condition = "0";
}




// ---------------------[ Data Collecton ]---------------------

$result = sql_query("SELECT `id`, `name`, `number`, `connectionID` FROM `caller_id` WHERE " . $condition . ";");

$total_result = $result->num_rows;
if ($total_result > 0) {
    $table_data = "";
    while ($row = $result->fetch_assoc()) {
        $connection_profile_link = profile_link($row["connectionID"]);
        $contact_name = contact_link($row["id"], $row["name"]);
        // $contact_number = contact_link($row["id"], $row["number"]);
        $table_data .= <<<HTML
            <tr>
                <td>$contact_name</td>
                <td>{$row["number"]}</td>
                <td>
                    <a
                    class = "text-decoration-none fw-bold text-secondary" 
                    href="$connection_profile_link">{$id_name_table[$row["connectionID"]]}</a>
                </td>
            </tr>
        HTML;
    }
    $search_reesult_body = <<<HTML
        <table class="table table-hover">
            <thead class="table-success">
                <tr>
                    <th>Name</th>
                    <th>Number</th>
                    <th>Connection with</th>
                </tr>
            </thead>
            <tbody class="data-sheet-body">
                $table_data
            </tbody>
        </table>
    HTML;
} else {
    $search_reesult_body = <<<HTML
        <div class="fs-5 text-center fw-bold text-secondary py-5">
            <i class="fa-solid fa-circle-xmark"></i> No Contact Found
        </div>
    HTML;
}



$search_box = <<<HTML
    <div id="search_box">
        <div class="card">
            <div class="card-header fw-bold text-secondary">Search Box</div>
            <div class="card-body">
                <form id="search_form" class="row g-3" method="get" enctype="multipart/form-data">
                    <div>
                        <input class="form-control" type="number" name="number" placeholder="01x xxxx-xxxx" value=$number>
                    </div>
                    <div>
                        <input class="form-control" type="text" name="name" placeholder="Name here..." value="$name">
                    </div>
                    <div>
                        <select name="relative" class="form-control">
                            $options
                        </select>
                    </div>
                    <div>
                        <button class="btn btn-outline-danger" onclick="document.getElementById('search_form').reset();">Reset</button>
                        <input class="btn btn-success float-end" name="submit" type="submit" value="Search">
                    </div>
                </form>
            </div>
        </div>
    </div>
HTML;

$search_result = <<<HTML
    <div id="search_result">
        <div class="card">
            <div class="card-header fw-bold text-secondary">
                Contact List
                <span class="float-end">$total_result Result Found</span>
            </div>
            <div class="card-body table-responsive">
                $search_reesult_body
            </div>
        </div>
    </div>
HTML;


$section_caller_id = <<<HTML
    <section id="caller_id">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">$search_box</div>
                <div class="col-lg-8">$search_result</div>
            </div>
        </div>
    </section>
HTML;

$main_sectoin = <<<HTML
    <main>
        $section_caller_id
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