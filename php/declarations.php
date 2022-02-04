<?php
    // This file has all of the general functions that I need to use across my code.

    // This function gets the next primary ID in a table.
    function nextID($table)
    {
        global $dbname, $conn;
        $idQuery = $conn->prepare("SELECT auto_increment AS ID
            FROM `information_schema`.`tables`
            WHERE table_name = :table
            AND table_schema = :db");
        $idQuery->execute(['table' => $table, 'db' => $dbname]);
        return $idQuery->fetch(PDO::FETCH_ASSOC)['ID'];
    }
?>