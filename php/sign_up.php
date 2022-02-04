<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'header.php'; ?>
    <title>Corn - Signup</title>
</head>

<body>
    <?php include 'nav.php';
    include 'connect.php'; ?>

    <div class="body">
        <div class="form">
            <!-- The form that just selects the image -->
            <form action="php/load_image.php" method="post" enctype="multipart/form-data" id="image_select_container" class="half">
                <input alt="Uplaod an Image" name="image" type="file" accept=".jfif, .png, .jpg" id="photo_upload">
                <label for="photo_upload">Upload Image</label>
                <input type="hidden" name="return" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                <input type="hidden" name="path" value="users" />
            </form>
            <form action="php/save_user.php" method="post" class="login_container" enctype="multipart/form-data">
                <?php
                if (array_key_exists('e', $_GET) and $_GET['e'] == 404) { // If there is an error thrown and the error is 404...
                ?>
                    <div class="row">
                        <p class="error">Error! Invalid username, password, image, or date of birth.</p>
                    </div>
                <?php } ?>
                <div class="row">
                    <p>Username: </p>
                    <input type="text" name="username">
                </div>
                <div class="row">
                    <p>Date of birth: </p>
                    <input type="date" name="dob">
                </div>
                <div class="row">
                    <p>Password: </p>
                    <input type="password" name="password"></p>
                </div>
                <div class="row">
                    <input type="submit">
                </div>
                <!-- Input element that contains the file is created by javascript after the above form is submitted -->
            </form>
        </div>
    </div>
</body>

</html>