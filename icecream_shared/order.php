<?php
    // Start the session
    session_start();

    // If the "Order Now" button is clicked
    if (isset($_POST['add']) && isset($_GET['id'])) {
        
        // Assign ice cream id to $id variable
        $id = $_GET['id'];

        // Check if a session for the cart is set already, if not, set one with empty value
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        // Add icecream id to the cart session using array_push function 
        array_push($_SESSION['cart'], $id);
    
        // Create another session called 'cart_dup', this session will hold the result from using array_count_values function
        // This array_count_values function will count how many time that icecream id is added to cart session
        $_SESSION['cart_dup'] = array_count_values($_SESSION['cart']);
    
        // Then, take the user to the cart page
        header('Location: cart.php');
    }
?>



