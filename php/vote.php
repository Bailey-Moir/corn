<?php
  // This file is used to save a vote to the server.

  session_start();
  include 'connect.php';

  if (array_key_exists('id', $_SESSION)) { // If the user exist...
    // Creats the vote select query.
    $voteSelectQuery = $conn->prepare("SELECT vote_id, value
    FROM vote
    WHERE user_id=:user AND post_id=:post;");

    // Runs the vote select query, where the post is the given post id and the user is session user id.
    $voteSelectQuery->execute([ 'post' => $_POST['post'], 'user' => $_SESSION['id']]);

    // Converts the query to a readable dictionary.
    $voteSelect = $voteSelectQuery->fetch(PDO::FETCH_ASSOC);

    // Prepares a post select query.
    $postSelectQuery = $conn->prepare("SELECT value
    FROM post
    WHERE post_id=:id");

    // Runs the post select query, where the id of the post is the posted post id.
    $postSelectQuery->execute([ 'id' => $_POST['post'] ]);

    // Gets the previous rating from the post select query.
    $previousRating = $postSelectQuery->fetch(PDO::FETCH_ASSOC)['value'];
    
    // Prepares the updatePostQuery to be used in the proceeding code code.
    $updatePostQuery = $conn->prepare("UPDATE post 
    SET value = :new_val
    WHERE post_id = :id;");

    // If the vote select query didn't work.
    if (gettype($voteSelect) != "boolean") { // If the user had already voted
      ['vote_id' => $vote_id, 'value' => $previousVote] = $voteSelect;
      // If the user is sending the same vote as before.
      if ($previousVote == $_POST['val']) echo $previousRating;
      else { // If the user is voting opposite to what they already had.
        // Sets up the query that updates the vote.
        $updateVoteQuery = $conn->prepare("UPDATE vote 
        SET 
            value = :val
        WHERE
            vote_id = :id;");

        // Updates the vote to the psot's vote value.
        $updateVoteQuery->execute([ 'val' => $_POST['val'], 'id' => $vote_id]);
        // Calculate the next rating and executes the update post query. Calculates as the previous rating - the previous vote + the new vote.
        $updatePostQuery->execute([ 'new_val' => $previousRating - (($previousVote == 0) ? -1 : 1) + (($_POST['val'] == 0) ? -1 : 1), 'id' => $_POST['post']]);
        
        // Echoes/Returns the new value.
        echo $previousRating - (($previousVote == 0) ? -1 : 1) + (($_POST['val'] == 0) ? -1 : 1);
      }
    } else { // If the user hadn't already voted
      // Creates the insert vote query
      $insertVoteQuery = $conn->prepare("INSERT INTO vote (post_id, user_id, value)
      VALUES (:post, :user, :val);");

      // Creats the vote with the posted value.
      $insertVoteQuery->execute([ 'post' => $_POST['post'], 'user' => $_SESSION['id'], 'val' => $_POST['val']]);
      // Updates the post with the new value. Calculted teh same as at line 50, except without taking away the previous value as there is none.
      $updatePostQuery->execute([ 'new_val' => $previousRating + (($_POST['val'] == 0) ? -1 : 1), 'id' => $_POST['post']]);

      // Echoes'returns the new value.
      echo $previousRating + (($_POST['val'] == 0) ? -1 : 1);
    }
  } else {
        // Prepares a post select query.
    $postSelectQuery = $conn->prepare("SELECT value
    FROM post
    WHERE post_id=:id");

    // Runs the post select query, where the id of the post is the posted post id.
    $postSelectQuery->execute([ 'id' => $_POST['post'] ]);

    // Gets the previous rating from the post select query and returns/echoes it.
    echo $postSelectQuery->fetch(PDO::FETCH_ASSOC)['value'];
  }
?>