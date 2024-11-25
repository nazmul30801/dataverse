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


function search_engine()
{
    $search_engine = <<<HTML
        <form action="/identity/index.php" role="search" method="get">
            <div class="input-group">
                <input type="search" class="form-control" placeholder="Search here ..." name="search">
                <button class="btn btn-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>
    HTML;
    return $search_engine;
}

