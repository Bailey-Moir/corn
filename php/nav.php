<div class="nav">
    <a href="/"><img class="icon" src="../imgs/favicon.png" alt="Icon"></a>
    <div id="buttons">
        <a href="/">Home</a>
        <?php
        if (array_key_exists('id', $_SESSION)) { // If the user is logged in...
        ?><a href="post">Post</a>
        <?php }
        ?>
        <a href="about">About</a>
    </div>
    <div id="account" <?php if (array_key_exists('id', $_SESSION)) echo 'onclick="toggleUserDropdown()"'; ?>>
        <?php
        if (!array_key_exists('id', $_SESSION)) { // If the user is logged in...
        ?><a href="login">Login</a>
            <a href="signUp">Sign Up</a>
        <?php } else {
        ?><p class="name"><?php echo $_SESSION['user']; // Displays the name ?></p>
            <img src="../imgs/users/<?php echo $_SESSION['id'] . "." . $_SESSION['avatar_type']; //Tells the tag where the image file is. ?>" alt="Your avatar" class="avatar">
            <div id="userDropdown" class="hide">
                <a href="profile?u=<?php echo $_SESSION['id']; //Defines what profile the user will look at when they press this button. ?>">View Profile</a>
                <a href="php/sign_out.php">Sign Out</a>
            </div>
        <?php }
        ?>
    </div>
</div>