<?php
    // This file is used when a user selects an image. It uploads the image to the server.

    include 'connect.php';
    include 'declarations.php';

    $path = $_POST['path'];

    // Gets the name that the file will be. The file name is equal to the post id.
    $fileName = nextID('post');
    if (array_key_exists(1, explode(".", $_FILES['image']['name']))) { // If the image exists, then do...
        // The file extension (include the dot).
        $uploadExtension = explode(".", $_FILES['image']['name'])[1];

        // Delete file if that file has already been loaded.
        $extensions = ['.jpg', '.png', '.jfif'];
        foreach ($extensions as $extension) {
            if(file_exists("../imgs/$path/$fileName.$extension")) unlink("../imgs/$path/$fileName.$extension");
        }

        // Move the uploaded file to the desired folder
        move_uploaded_file($_FILES['image']['tmp_name'], "../imgs/$path/$fileName.$uploadExtension");

        // Makes the file output the file name (including the extension).
        echo "$path/$fileName.$uploadExtension";
    } else { // If the image doesn't exist...
        echo "N/A";
    }
?>