<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'header.php'; ?>
    <title>Corn - Login</title>
</head>

<body>
    <?php include 'nav.php';
    include 'connect.php'; ?>

    <div class="body">
        <form action="php/load_user.php" method="post" class="login_container">
            <?php
            if (array_key_exists('e', $_GET) and $_GET['e'] == 404) { // If there is an error thrown and the error is 404...
            ?>
                <div class="row">
                    <p class="error">Error! Invalid username or password</p>
                </div>
            <?php }
            ?>
            <div class="row">
                <p>Username: </p>
                <input type="text" name="username">
            </div>
            <div class="row">
                <p>Password: </p>
                <input type="password" name="password"></p>
            </div>
            <div class="row">
                <input type="submit">
            </div>
        </form>
    </div>
</body>

</html>