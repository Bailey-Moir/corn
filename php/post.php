<?php session_start();; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'header.php'; ?>
    <title>Corn - Post</title>
</head>

<body>
    <?php include 'connect.php';
    include 'nav.php'; ?>

    <div class="body">
        <div class="form full">
            <!-- The form that just selects the image -->
            <form action="php/load_image.php" method="post" enctype="multipart/form-data" id="image_select_container" class="full">
                <input alt="Upload Image" name="image" type="file" accept=".jfif, .png, .jpg" id="photo_upload">
                <label for="photo_upload">Upload Image</label>
                <input type="hidden" name="return" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                <input type="hidden" name="path" value="posts" />
            </form>
            <form action="php/save_post.php" method="post" enctype="multipart/form-data">
                <textarea name="caption" resize="none" placeholder="Caption..."></textarea>
                <input type="submit">
                <!-- Input element that contains the file is created by javascript after the above form is submitted -->
            </form>
        </div>
    </div>
</body>

</html>