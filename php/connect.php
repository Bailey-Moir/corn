<?php
    // This page connects to the database.
    $servername = "localhost";
    $username = "root";
    $dbname = "2021year11_baileymoir";

    // Create connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
