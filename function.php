<?php


function create_conn()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dataverse";
    // Create connection
    $connection = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($connection->connect_error) {
        echo $connection->connect_error;
    }
    return $connection;

}




function sql_query($sql)
{
    $connection = create_conn();
    $result = $connection->query($sql);
    $connection->close();
    return $result;
}
