<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'header.php'; ?>
    <title>Corn - View Profile</title>
</head>

<body>
    <?php include 'connect.php';
    include 'nav.php'; ?>

    <div class="body vertical">
        <div class="user_header">
            <div class="author">
                <?php
                $stmt = $conn->prepare("SELECT user.avatar_type, user.name, user.user_id 
                    FROM user 
                    WHERE user.user_id=:id");
                $stmt->execute(['id' => $_GET['u']]);
                // The user data.
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                // The string that goes on the end of the user's name to make it possessive.
                $possessive = '\'' . (substr($user['name'], -1) == 's' ? '' : 's');
                ?>
                <img src="../imgs/users/<?php echo $user['user_id'] . "." . $user['avatar_type']; ?>" alt="<?php echo $user['name'] . $possessive . ' avatar'; ?>" class="avatar">
                <p class="name"><?php echo $user['name']; ?></p>
            </div>
        </div>
        <div class="posts full">
            <?php
            $stmt = $conn->prepare("SELECT post.post_id, post.image_type, post.value, post.caption, post.time, user.avatar_type, user.name, user.user_id 
                FROM post 
                INNER JOIN user WHERE post.user_id=user.user_id
                AND user.user_id=:id
                ORDER BY time DESC");
            $stmt->execute(['id' => $_GET['u']]);
            while ($post = $stmt->fetch(PDO::FETCH_ASSOC)) { // Loops through the posts that the user created.
            ?><div class="post vertical">
                    <a class="content" href="viewPost?p=<?php echo $post['post_id']; ?>">
                        <p><?php echo $post['caption']; ?></p>
                        <div class="image_container vertical">
                            <img class="main" src="../imgs/posts/<?php echo $post['post_id'] . "." . $post['image_type']; ?>" class="main_image" alt="Picture of corn">
                        </div>
                    </a>
                    <div class="seperator"></div>
                    <div class="header">
                        <div class="author">
                            <img src="../imgs/users/<?php echo $post['user_id'] . "." . $post['avatar_type']; ?>" alt="<?php echo $post['name'] . $possessive . ' avatar'; ?>" class="avatar">
                            <div class="row">
                                <p class="name"><?php echo $post['name']?></p>
                                <p class="time"><?php echo $post['time']?></p>
                            </div>
                        </div>
                        <div class="up_down vertical">
                            <!-- Sends the post id to the function -->
                            <a onclick="up(this, <?php echo $post['post_id']; ?>)" class="up"><img src="../imgs/up.png" alt="Up vote"/></a>
                            <p><?php echo $post['value']; ?></p>
                            <a onclick="down(this, <?php echo $post['post_id']; ?>)" class="down"><img src="../imgs/down.png" alt="Down vote" class="down"/></a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>