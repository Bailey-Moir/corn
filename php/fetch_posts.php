<?php
include 'connect.php';

if (isset($_POST['s'])) { // If the sort mode is defined...
    if ($_POST['s'] == 'r') { // If the sort mode is recent.
        // Getshte post and user values, ordered by the rating.
        $posts_raw = $conn->query("SELECT post.post_id, post.image_type, post.value, post.caption, post.image_height, post.time, user.avatar_type, user.name, user.user_id 
        FROM post 
        INNER JOIN user WHERE post.user_id=user.user_id
        ORDER BY post.value DESC;");
    } else { // If the osrt mode is latest.
        // Getshte post and user values, ordered by the time.
        $posts_raw = $conn->query("SELECT post.post_id, post.image_type, post.value, post.caption, post.image_height, post.time, user.avatar_type, user.name, user.user_id 
        FROM post 
        INNER JOIN user WHERE post.user_id=user.user_id
        ORDER BY post.time DESC;");
    }
} else { // If the sort mode isn't defined...
    // Sort by time as default.
    $posts_raw = $conn->query("SELECT post.post_id, post.image_type, post.value, post.caption, post.image_height, post.time, user.avatar_type, user.name, user.user_id 
        FROM post 
        INNER JOIN user WHERE post.user_id=user.user_id
        ORDER BY post.time DESC;");
}

$lch = 0; // The left coloums height.
$rch = 0; // The right coloums height.
$lc = []; // The left column items.
$rc = []; // THe right column items.

while ($item = $posts_raw->fetch(PDO::FETCH_ASSOC)) { // For each post..
    if ($lch > $rch) { // If the left hands height is larger than the right hands height...
        // Add the post to the right column
        array_push($rc, $item);
        // Adds the image's height to the right column height.
        $rch += $item['image_height'];
    } else {
        // Add the post to the left column
        array_push($lc, $item);
        // Adds the image's height to the left column height.
        $lch += $item['image_height'];
    }
}
?>
<div class="posts half">
    <?php
    foreach ($lc as $post) { //For each post in the left coloumn.
        // The string to add to the end of the poster's name to make it posessive.
        $post_possessive = '\'' . (substr($post['name'], -1) == 's' ? '' : 's');
    ?><div class="post vertical">
            <a class="content" href="viewPost?p=<?php echo $post['post_id']; ?>">
                <p><?php echo $post['caption']; ?></p>
                <div class="image_container vertical">
                    <img class="main" src="../imgs/posts/<?php echo $post['post_id'] . "." . $post['image_type']; ?>" class="main_image" alt="Picture of corn">
                </div>
            </a>
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
        </div>
    <?php } ?>
</div>
<div class="posts half">
    <?php
    foreach ($rc as $post) { //For each post in the right coloumn.
        // The string to add to the end of the poster's name to make it posessive.
        $post_possessive = '\'' . (substr($post['name'], -1) == 's' ? '' : 's');
    ?><div class="post vertical">
            <a class="content" href="viewPost?p=<?php echo $post['post_id']; ?>">
                <p><?php echo $post['caption']; ?></p>
                <div class="image_container vertical">
                    <img class="main" src="../imgs/posts/<?php echo $post['post_id'] . "." . $post['image_type']; ?>" class="main_image" alt="Picture of corn">
                </div>
            </a>
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
        </div>
    <?php } ?>
</div>