<?php

$root_dir = "../";
$page_id = 4;
require $root_dir . "page_handler.php";



require "function.php";



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


    $name_list = sql_query("SELECT `id`, `fullName` FROM `main` WHERE id IN ($connection_id_list);");

    $id_name_table = [];
    $options = "";
    $option1 = "";
    while ($row = $name_list->fetch_assoc()) {
        $id_name_table += [$row["id"] => $row["fullName"]];
        $options .= <<<HTML
            <option value="{$row['id']}">{$row["fullName"]}</option>
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
        $table_data .= <<<HTML
            <tr>
                <td>{$row["name"]}</td>
                <td>{$row["number"]}</td>
                <td>{$id_name_table[$row["connectionID"]]}</td>
            </tr>
        HTML;
    }
} else {
    $table_data = <<<HTML
        <tr>
            <td colspan='4' style='padding:5rem 0;'>No Data</td>
        </tr>
    HTML;
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
        <section id="caller_id">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <div id="search_box">
                            <div class="card">
                                <div class="card-header">Search Box</div>
                                <div class="card-body">
                                    <form id="search_form" class="row g-3" method="get" enctype="multipart/form-data">
                                        <div>
                                            <input class="form-control" type="number" name="number" placeholder="01x xxxx-xxxx" value=<?php echo $number; ?>>
                                        </div>
                                        <div>
                                            <input class="form-control" type="text" name="name" placeholder="Name here..." value="<?php echo $name; ?>">
                                        </div>
                                        <div>
                                            <select name="relative" class="form-control">
                                                <?php echo $options; ?>
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
                    </div>
                    <div class="col-lg-8">
                        <div id="search_result">
                            <div class="card">
                                <div class="card-header">Result</div>
                                <div class="card-body table-responsive">
                                    <table class="table table-striped">
                                        <thead class="table-success">
                                            <tr class=""
                                                <th>Name</th>
                                                <th>Number</th>
                                                <th>Relative</th>
                                            </tr>
                                        </thead>
                                        <tbody class="data-sheet-body">
                                            <?php echo $table_data; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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