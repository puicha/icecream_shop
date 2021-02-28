<?php
    // Create connection
    $conn = mysqli_connect('localhost','xxx','xxxx','morse_icecream');
    
    // Check connection
    if(!$conn){
        echo 'Connection error: '. mysqli_connect_error();
    }
    // sql to create user table
    $sql = "CREATE TABLE users (
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )";
if (mysqli_query($conn, $sql)){
    echo "Table users created successfully";
} else {
    echo "Error creating table: ". mysqli_error($conn);
}
mysqli_close($conn);   
?>