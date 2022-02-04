<?php
    session_start();
    include 'connect.php';

    /* Makes sure that
    *   - The username isn't just spaces or nothing.
    *   - The password isn't just spaces or nothing/
    *   - There was an image submitted.
    *   - The date of birth is set.
    */
    if (str_replace(" ", "", $_POST['username']) == "" or str_replace(" ", "", $_POST['password']) == "" or !array_key_exists('image', $_FILES) || $_POST['dob'] == "") {        
        // Throws an error to the sign up page.
        header("Location: /signUp?e=404");
        die();
    } else {
        // Prepares the user insert query.
        $stmt = $conn->prepare("INSERT INTO user (avatar_type, name, dob, pass)
        VALUES (:avatar_type, :name, :dob, :password);");

        // If the submitting failed...
        if ($stmt->execute([ 'avatar_type' => explode(".", $_FILES['image']['name'])[1], 'name' => $_POST['username'], 'dob' => $_POST['dob'], 'password' => hash('ripemd160', $_POST['password']) ]) == False) echo "Not sumbitted... <br/>";
        else { // If the submitting succeded...
            // Save the information to the sessinon.
            $_SESSION['id'] = $conn->lastInsertId();
            $_SESSION['user'] = $_POST['username'];
            $_SESSION['avatar_type'] = explode(".", $_FILES['image']['name'])[1];

            // Redirect to the home page.
            header("Location: ../");
            die();
        }
    }
?>