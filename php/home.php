<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'header.php'; ?>
    <title>Corn - Home</title>
</head>

<body>
    <?php include 'connect.php';
    include 'nav.php'; ?>

    <div class="body">
        <!-- This button opens and closes the sort selection. -->
        <a onclick="toggleSortDropdown()" id="sortOpenBtn" class="sort">Latest</a>
        <!-- This is the sort selection. -->
        <div id="sortByDropdown" class="sort hide">
            <!-- The button that switches the sort mode to latest -->
            <div id="latest" class="sortItem row selected sort">
                <img src="../imgs/tick.png" class="marker sort">
                <p class="sort">Latest</p>
            </div>
            <!-- The button that switches the sort mode to rating -->
            <div id="rating" class="sortItem sort row">
                <p class="sort">Rating</p>
            </div>
        </div>
        <!-- ALl the posts will be in this div tag -->
        <div id="posts" style="display: flex;">
            <?php include 'fetch_posts.php' ?>
        </div>
    </div>
</body>

</html>