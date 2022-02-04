<?php
        // This is a temporary file that is used to see the contents of a table.
        include 'connect.php';

        $table_raw = $conn->query("SELECT * FROM {$_GET['t']};");

        if ($table_raw->rowCount() > 0) {
                // output data of each row
                while($row = $table_raw->fetch(PDO::FETCH_ASSOC)) echo implode(", ", $row) . "<br/>";
        } else echo "0 results";
?>