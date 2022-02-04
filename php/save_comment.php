<?php
  // This file is used to save a comment to the server. Run after a comment is submitted.

  session_start();
  include 'connect.php';
  
  $stmt = $conn->prepare("INSERT INTO comment (post_id, user_id, text)
  VALUES (:post, :user, :comment);");

  $stmt->execute([ 'post' => $_POST['post'], 'user' => $_SESSION['id'], 'comment' => $_POST['comment'] ]);

  // Redirects to the post that was just commeneted on.
  header("Location: /viewPost?p={$_POST['post']}");
  die();
?>
