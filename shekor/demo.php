<?php

include('dbconnect.php');

$sql = "SELECT * FROM `citizens_profile` Where `gen_id` = '11';SELECT * FROM `citizens_profile` Where `gen_id` like '".$gen_id."_';";
$result1 = $conn->query($sql);
if ($result1->num_rows > 0) {
    // output data of each row
    while ($row = $result1->fetch_assoc()) {
        print_r($row);
    }
} else {
    echo "0 results";
}



// $sql = "SELECT * FROM `citizens_profile` Where `gen_id` like '" . $gen_id . "_';";
// $result1 = $conn->query($sql);
// if ($result1->num_rows > 0) {
//     // output data of each row
//     while ($row = $result1->fetch_assoc()) {
//         $profile = array("gen_id" => $row["gen_id"], "name" => $row["name"], "name" => $row["name"]);
//         $gen_id = $row["gen_id"];
//         $name = $row["name"];
//         $gender = $row["gender"];
//         $job = $row["occupation"];
//         $dob = $row["dob"];
//     }
// } else {
//     echo "0 results";
// }
$conn->close();
