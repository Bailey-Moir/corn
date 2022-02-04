<?php
  // This file is used to save a post to the server. The saving of the image is done in load_image.php

  session_start();
  include 'connect.php';
  include 'declarations.php';
  
  $stmt = $conn->prepare("INSERT INTO post (image_type, caption, user_id, image_height)
  VALUES (:image_type, :cap, :user, :height);");

  // Gets the image width and height.
  list($width, $height) = getimagesize("../imgs/posts/". nextID('post') .".".explode(".", $_FILES['image']['name'])[1]);

  $stmt->execute([ 'image_type' => explode(".", $_FILES['image']['name'])[1], 'cap' => $_POST['caption'], 'user' => $_SESSION['id'], 'height' => $height/$width]);

  // Redirects to the home page.
  header("Location: ../");
  die();
?>
