<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'header.php'; ?>
    <title>Corn - View Post</title>
</head>

<body>
    <?php include 'nav.php';
    include 'connect.php'; ?>

    <div class="body vertical">
        <div class="posts full">
            <?php
            $post_raw = $conn->query("SELECT post.post_id, post.image_type, post.value, post.caption, post.time, user.avatar_type, user.name, user.user_id 
                FROM post 
                INNER JOIN user WHERE post.user_id=user.user_id AND post.post_id='" . $_GET["p"] . "';");
            while ($post = $post_raw->fetch(PDO::FETCH_ASSOC)) {
                // The string that goes on the end of the user's name to make it possessive.
                $post_possessive = '\'' . (substr($post['name'], -1) == 's' ? '' : 's');
            ?><div class="post vertical">
                <div class="content">
                    <p><?php echo $post['caption']; ?></p>
                    <div class="image_container vertical">
                        <img class="main" src="../imgs/posts/<?php echo $post['post_id'] . "." . $post['image_type']; ?>" class="main_image" alt="Picture of corn">
                    </div>
                </div>
                <div class="seperator"></div>
                <div class="header">
                    <a class="author" href="profile?u=<?php echo $post['user_id']; ?>">
                        <img src="../imgs/users/<?php echo $post['user_id'] . "." . $post['avatar_type']; ?>" alt="<?php echo $post['name'] . $post_possessive . ' avatar'; ?>" class="avatar">
                        <div class="row">
                            <p class="name"><?php echo $post['name']?></p>
                            <p class="time"><?php echo $post['time']?></p>
                        </div>
                    </a>
                    <div class="up_down vertical">
                        <!-- Sends the post id to the function -->
                        <a onclick="up(this, <?php echo $post['post_id']; ?>)" class="up"><img src="../imgs/up.png" alt="Up vote"/></a>
                        <p><?php echo $post['value']; ?></p>
                        <a onclick="down(this, <?php echo $post['post_id']; ?>)" class="down"><img src="../imgs/down.png" alt="Down vote" class="down"/></a>
                    </div>
                </div>
                <?php if (isset($_SESSION['id'])) { ?>
                <div class="comments">
                    <p>Comments:</p>
                    <form action="php/save_comment.php" method="post">
                        <textarea name="comment" resize="none" placeholder="Comment..."></textarea>
                        <input type="submit">
                        <input type="hidden" name="post" value="<?php echo $post['post_id']; ?>">
                    </form>
                    <?php
                    $comments_raw = $conn->query("SELECT user.user_id, user.avatar_type, user.name, comment.text, comment.time, comment.comment_id
                            FROM comment 
                            INNER JOIN user WHERE comment.user_id=user.user_id AND comment.post_id='" . $post['post_id'] . "'
                            ORDER BY comment.time DESC;");
                    while ($comment = $comments_raw->fetch(PDO::FETCH_ASSOC)) { // Loops through the comments.
                        // The string that goes on the end of the user's name to make it possessive.
                        $comment_possessive = $comment['name'] . '\'' . (substr($comment['name'], -1) == 's' ? '' : 's');
                    ?><div class="comment">
                            <a class="author" href="profile?u=<?php echo $comment['user_id']; ?>">
                                <img src="../imgs/users/<?php echo $comment['user_id'] . "." . $comment['avatar_type']; ?>" alt="<?php echo $comment_possessive . ' avatar'; ?>" class="avatar">
                                <div class="row">
                                    <p class="name"><?php echo $comment['name']?></p>
                                    <p class="time"><?php echo $comment['time']?></p>
                                </div>
                            </a>
                            <p><?php echo $comment['text']; ?></p>
                        </div>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</body>

</html>