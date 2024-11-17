<?php

$root_dir = "../";
$page_id = 4;
require $root_dir . "page_handler.php";



require "function.php";



if (isset($_GET["submit"])) {
    $name = htmlspecialchars($_GET["name"]);
    $number = htmlspecialchars($_GET["number"]);
    $relative = htmlspecialchars($_GET["relative"]);
} else {
    $name = "";
    $number = "";
    $relative = "";
}





// ---------------------[ Collect Profile List ]---------------------

$result = sql_query("SELECT DISTINCT `get_from` FROM `caller_id`;", "data_center");
if ($result->num_rows > 0) {
    if ($relative != "") {
        $select_state = "";
        $option1 = '<option value="' . $relative . '" selected>' . $relative . '</option>';
    } else {
        $select_state = "selected";;
        $option1 = "";
    }
    $options = '<option value="none" ' . $select_state . ' disabled>Select a Relative</option>
    ' . $option1 . '
    <option value="all">All</option>';
    while ($row = $result->fetch_assoc()) {
        $options .= '<option value="' . $row["get_from"] . '">' . $row["get_from"] . '</option>';
    }
} else {
    $options = "<option value='none' disabled selected>No Relative Found</option>";
}









// ---------------------[ Making Conditions ]---------------------

$number_condition = make_condition($number, "number");
$name_condition = make_condition($name, "name");
if ($relative == "all") {
    $relative_condition = "";
} else {
    $relative_condition = make_condition($relative, "get_from");
}
$condition = "1" . $number_condition . $name_condition . $relative_condition;
if ($condition == "1" and $relative == "all") {
    $condition = "1";
} elseif ($condition == "1") {
    $condition = "0";
}




// ---------------------[ Data Collecton ]---------------------

$result = sql_query("SELECT `id`, `name`, `number`, `get_from` FROM `caller_id` WHERE " . $condition . ";", "data_center");

$total_result = $result->num_rows;
if ($total_result > 0) {
    $table_data = "";
    while ($row = $result->fetch_assoc()) {
        $table_data = $table_data . "
<tr>
    <td>" . $row["id"] . "</td>
    <td>" . $row["name"] . "</td>
    <td>" . $row["number"] . "</td>
    <td>" . $row["get_from"] . "</td>
</tr>";
    }
} else {
    $table_data = "
<tr>
    <td colspan='4' style='padding:5rem 0;'>No Data</td>
</tr>";
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
                                            <tr class="">
                                                <th>ID</th>
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