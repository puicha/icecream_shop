<?php
    // Start the session
    session_start();

    // Unset cart session
    unset($_SESSION['cart']); 

    // Redirect to cart_empty page
    header("location: cart_empty.php");
?>