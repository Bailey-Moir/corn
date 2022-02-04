<?php
    // This file resets/creates the database.

    session_start();
    $_SESSION = [];
    session_destroy();

    $servername = "localhost";
    $username = "root";
    $dbname = "2021year11_baileymoir";

    // Create connection
    $conn = new PDO("mysql:host=$servername", $username);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $conn->query("DROP DATABASE IF EXISTS $dbname;");
    $conn->query("CREATE DATABASE $dbname;");
    $conn->query("USE $dbname;");

    $conn->query("CREATE TABLE post (
        post_id INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        image_type VARCHAR(9) NOT NULL,
        image_height FLOAT(3) NOT NULL,
        caption VARCHAR(250),
        value INT(4) DEFAULT 0,
        user_id INT(4) NOT NULL,
        time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );");
    $conn->query("CREATE TABLE user (
        user_id INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        avatar_type VARCHAR(9) NOT NULL,
        name VARCHAR(18) NOT NULL,
        dob CHAR(10) NOT NULL,
        pass VARCHAR(40) NOT NULL
    );");
    $conn->query("CREATE TABLE comment (
        comment_id INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        post_id INT(4) NOT NULL,
        user_id INT(4) NOT NULL,
        text VARCHAR(250) NOT NULL,
        time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );");
    $conn->query("CREATE TABLE vote (
        vote_id INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        post_id INT(4) NOT NULL,
        user_id INT(4) NOT NULL,
        value INT(1) NOT NULL
    );");

    
    // List of name of files inside folder
    $files = array_merge(glob('imgs/posts/*'), glob('imgs/users/*')); 
    
    // Deleting all the files in the list
    foreach($files as $file) {
        // Delete the given file
        if(is_file($file) && $file != "imgs/favicon.png") unlink($file); 
    }

    header("Location: ../");
    die();
?>