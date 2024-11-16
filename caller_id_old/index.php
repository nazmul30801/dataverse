<?php
include "config/config.php";
include "function.php";
$table = "caller_id";

$name = set_form_value("name");
$number = strval(set_form_value("number"));
$relative = set_form_value("relative");
$result = $conn->query("SELECT DISTINCT `get_from` FROM `$table`;");
if ($result->num_rows > 0) {
    if ($relative != "") {
        $select_state = "";
        $option1 = '<option value="'.$relative.'" selected>'.$relative.'</option>';
    } else {
        $select_state = "selected";
        ;$option1 = "";
    }
    $options = '<option value="none" '.$select_state.' disabled>Select a Relative</option>
    '.$option1.'
    <option value="all">All</option>';
    while ($row = $result->fetch_assoc()) {
        $options .= '<option value="' . $row["get_from"] . '">' . $row["get_from"] . '</option>';
    }
} else {
    $options = "<option value='none' disabled selected>No Relative Found</option>";
}


$number_condition = make_condition("number", "number");
$name_condition = make_condition("name", "name");
if ($relative == "all") {
    $relative_condition = "";
} else {
    $relative_condition = make_condition("relative", "get_from");
}
$condition = "1" . $number_condition . $name_condition . $relative_condition;
if ($condition == "1" and $relative == "all") {
    $condition = "1";
} elseif ($condition == "1") {
    $condition = "0";
}
$sql = "SELECT `id`, `name`, `number`, `get_from` FROM `$table` WHERE " . $condition . ";";
$result = $conn->query($sql);

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
$conn->close();
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
                <li><a href="#">Home</a></li>
                <li><a href="vcf-collector.php">VCF Collector</a></li>
                <li><a href="demo.php">Demo</a></li>
                <li><a href="uploads/">Uploads</a></li>
            </ul>
        </nav>
    </section>
    <section class="main-section">

        <section class="search-box">
            <form class="search-form" method="get">
                <div class="search-form-header">Search Box</div>
                <div class="search-form-body">
                    <input name="number" type="number" placeholder="01x xxxx-xxxx" value=<?php echo $number ?>>
                    <input name="name" type="text" placeholder="Name here..." value="<?php echo $name ?>">
                    <select name="relative">
                        <?php echo $options; ?>
                    </select>
                    <input type="submit" value="Search">
                </div>
            </form>
        </section>
        <section class="data-sheet">
                <div class="caption"><?php echo $total_result." Results Found"?></div>
            <table class="data-sheet-table">
                <thead class="data-sheet-head">
                    <tr>
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
        </section>
    </section>
</body>

</html>