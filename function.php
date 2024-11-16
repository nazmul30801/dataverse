<?php


function create_conn($database = "dataverse")
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    // Create connection
    $connection = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($connection->connect_error) {
        echo $connection->connect_error;
    }
    return $connection;

}




function sql_query($sql, $database = "dataverse")
{
    $connection = create_conn($database);
    $result = $connection->query($sql);
    $connection->close();
    return $result;
}
