<?php
    /*
    * This file is unlike the others. It processes the url and redirects to corresponding files.
    */
    [$page] = explode("?", $_SERVER['REQUEST_URI']);

    $urls = [ // Aliases
        "" => "home.php",
        "about" => "about.php",
        "login" => "login.php",
        "post" => "post.php",
        "profile" => "profile_view.php",
        "signUp" => "sign_up.php",
        "viewPost" => "view_post.php",
        "test" => "test.php",
        "reset" => "reset.php"
    ];

    // For each of the aliases
    foreach($urls as $url=>$file) {
        // If the page matches the alias.
        if ($page == "/".$url) {
            // Load the page
            include("php/".$file);
            // Stop looping
            return;
        }
    }
?>