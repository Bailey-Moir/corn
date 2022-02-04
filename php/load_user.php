<?php
    // This file logs the user in. Is run after the user submits in 'login.php'.

    session_start();
    include 'connect.php';

    // Prepares the select query.
    $stmt = $conn->prepare("SELECT user.user_id, user.name, user.avatar_type, user.pass 
    FROM user 
    WHERE user.name=:name
    AND user.pass=:password;");

    // Executes the prepared query. Hashes the password to enecrypt it.
    $stmt->execute([ 'name' => $_POST['username'], 'password' => hash('ripemd160', $_POST['password']) ]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data == True) { // If the user exists...
        // Adds the data to the session.
        $_SESSION['id'] = $data['user_id'];
        $_SESSION['user'] = $data['name'];
        $_SESSION['avatar_type'] = $data['avatar_type'];

        // Go the home page.
        header("Location: ../");
        die();
    } else { // If the user doesn't exist, throw an error.
        header("Location: /login?e=404");
        die();
    }
?>