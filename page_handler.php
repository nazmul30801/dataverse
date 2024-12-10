<?php

require "sections.php";

$result = sql_query("SELECT * FROM pages WHERE `id` = $page_id");
if ($result && $row = $result->fetch_assoc()) {
    $title = $row["title"];
} else {
    $title = "Not Found";
}