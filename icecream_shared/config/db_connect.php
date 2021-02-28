<?php
    // Use MySQLi Object-oriented for MySQL database
    // Connect to the database
    $conn = new mysqli('localhost', 'xxx', 'xxxx', 'morse_icecream');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
?>