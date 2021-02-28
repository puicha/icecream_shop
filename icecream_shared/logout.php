<?php
    // Start the session
    session_start();

    // When the user clicks logout button, Unset all session variables, distroy the session, then redirect to home page
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to home page
    header("location: index.php");
?>
