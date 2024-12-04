<?php

require "sections.php";

$result = sql_query("SELECT * FROM pages WHERE `id` = $page_id");
if ($result && $row = $result->fetch_assoc()) {
    $title = $row["title"];
} else {
    $title = "Not Found";
}


$page = [
    "home" => "/index.php",
    "search" => "/search.php",
    "profile" => "/profile.php",
    "add-profile" => "/add-profile.php",
    "update-profile" => "/update-profile.php",
    "caller_id" => "/caller_id/index.php",
    "contact" => "/caller_id/contact.php",
    "shekor" => "/shekor/index.php"
];