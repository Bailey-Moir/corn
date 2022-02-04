<?php
    // Clears and destroys the session.
    session_start();
    $_SESSION = [];
    session_destroy();

    // Redirects to the home page.
    header("Location: ../");
    die();
?>