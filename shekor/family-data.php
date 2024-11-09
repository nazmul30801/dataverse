<?php

    if (isset($_GET["gen_id"])) {
        $gen_id = $_GET["gen_id"];
        include('dbconnect.php');

        $sql = "SELECT * FROM `citizens_profile` Where `gen_id` = ".$gen_id.";";
        $result1 = $conn->query($sql);
        if ($result1->num_rows > 0) {
            // output data of each row
            while ($row = $result1->fetch_assoc()) {
                $gen_id = $row["gen_id"];
                $name = $row["name"];
                $gender = $row["gender"];
                $job = $row["occupation"];
                $dob = $row["dob"];
            }
        } else {
            echo "0 results";
        }

        $sql2 = "SELECT * FROM `citizens_profile` WHERE gen_id LIKE '".$gen_id."_';";
        $result2 = $conn->query($sql);
        if ($result2->num_rows > 0) {
            // output data of each row
            while ($row = $result2->fetch_assoc()) {
                $profile = array("gen_id" => $row["gen_id"], "name" => $row["name"], "name" => $row["name"] );
                $gen_id = $row["gen_id"];
                $name = $row["name"];
                $gender = $row["gender"];
                $job = $row["occupation"];
                $dob = $row["dob"];
            }
        } else {
            echo "0 results";
        }
        $conn->close();
    } else {
        $gen_id = "";
        $name = "";
        $gender = "";
        $job = "";
        $dob = "";
    }


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>শেকড়</title>
</head>

<body>
    <header>
        <div class="header-title">শেকড়</div>
    </header>
    <section id="section-subdata">
        <div class="row">
            <div class="col-6">
                <div class="data-view">পরিবার প্রধান : <?php echo $name ?></div>
            </div>
            <div class="col-3">
                <div class="data-view">প্রজন্ম : ৫ম</div>
            </div>
            <div class="col-3">
                <form id="search-form" action="index.php" method="get">
                    <input name="gen_ id" type="text">
                    <input type="submit" value="Find">
                </form>
            </div>
        </div>
    </section>
    <section id="section-gen-series">
        <div class="row">
            <div class="col-12">
                <span style="font-weight: bold;">বংশানুক্রম :</span> চাঁন গাজী > করিম বক্স > মোন্তাজউদ্দিন প্রধানীয়া >
                হাসেম ডাক্তার > <?php echo $name ?>
            </div>
        </div>
    </section>
    <section id="section-family-mamber">
        <div class="row">
            <div class="col-12">
                <table id="data-table">
                    <caption>পরিবারের সদস্যগন</caption>
                    <tr>
                        <th>ID</th>
                        <th>নাম</th>
                        <th>পদবি
                        </th>
                        <th>জন্ম তারিখ</th>
                    </tr>
                    <tr>
                        <td>123456</td>
                        <td>মোস্তফা কামাল</td>
                        <td>পরিবার প্রধান</td>
                        <td>1970-01-01</td>
                    </tr>
                    <a href='?id=54'><tr>
                        <td>রুনিয়া আক্তার</td>
                        <td>স্ত্রী</td>
                        <td>1970-01-01</td>
                        <td>123456</td>
                    </tr></a><a href="http://">asdfasdf</a>
                    <tr>
                        <td>123456</td>
                        <td>মুন্না</td>
                        <td>ছেলে</td>
                        <td>1970-01-01</td>
                    </tr>
                    <tr>
                        <td>123456</td>
                        <td>নাবিলা</td>
                        <td>মেয়ে</td>
                        <td>1970-01-01</td>
                    </tr>
                    <tr>
                        <td>123456</td>
                        <td>আব্দুর রহমাল</td>
                        <td>ছেলে</td>
                        <td>1970-01-01</td>
                    </tr>
                </table>
            </div>
        </div>
    </section>
    <hr>
    <section id="section-family-head">
        <div class="row">
            <div class="col-12">
                <table id="data-table">
                    <caption>পরিবার প্রধানের তথ্য</caption>
                    <tr>
                        <td>ID</td>
                        <td><?php echo $gen_id ?></td>
                    </tr>
                    <tr>
                        <td>নাম</td>
                        <td><?php echo $name ?></td>
                    </tr>
                    <tr>
                        <td>জন্ম তারিখ</td>
                        <td><?php echo $dob ?></td>
                    </tr>
                    <tr>
                        <td>লিঙ্গ</td>
                        <td><?php echo $gender ?></td>
                    </tr>
                    <tr>
                        <td>বয়ষ</td>
                        <td>৫০</td>
                    </tr>
                    <tr>
                        <td>পেশা</td>
                        <td><?php echo $job ?></td>
                    </tr>
                    <tr>
                        <td>মোবাইল নম্বর</td>
                        <td>01987654321</td>
                    </tr>
                    <tr>
                        <td>NID নম্বর</td>
                        <td>1234534523456</td>
                    </tr>
                </table>
            </div>
        </div>
    </section>



</body>

</html>