<?php
    /* 2-26-2021 This application demonstrates ice cream shop website with HTML, CSS and
       JavaScript for front-end and PHP for back-end.  Database used for this application is MySQL.  The database contains
       Ice cream items table and users table.  The application is using materialize CSS for theme and layout.
       It is also responsive web application with following features:
        - Create account, login and reset password for the user.  
        - Order feature that will add order in the shopping cart.
        - Shopping Cart feature that use session to keep order in the cart.
        - Shopping cart is available for both guest and users who login.  Cart can be reset, continue shopping or proceed to checkout.
        - Also have cart icon on the header that will show order quantity.  
        - The order quantity displayed on the cart icon is updated automatically.
        - Checkout page with the form for the user to enter shipping address and credit card payment. 
        - Checkout page also displays the ordered items. 
    */
    
    // Start the session
    session_start();

    // Call db_connect.php to connect to database
    require_once 'config/db_connect.php';

    // Query SELECT statement to get data from database, execute the query
    $sql = "SELECT id, title, price, image FROM icecream";
    $result = $conn->query($sql);
    
    // Fetch data result and store in $icecream_array, use MYSQLI_ASSOC option for associative array
    $icecream_array = $result->fetch_all(MYSQLI_ASSOC);
    
    // Free result set
    $result->free_result();
    
    // Close connection
    $conn->close();
?>

<!DOCTYPE html>
<html>
    <!--Include header-->
    <?php include 'templates/header.php'; ?>

    <h4 class="center grey-text">Hi, Welcome to our site</h4>
    
    <!--Display slideshow-->
    <div class="carousel carousel-slider" data-indicators="true">
        <a class="carousel-item" href="#one"><img src="img/slide/slide3.jpeg"></a>
        <a class="carousel-item" href="#two"><img src="img/slide/slide2.jpg"></a>
        <a class="carousel-item" href="#three"><img src="img/slide/slide1.jpeg"></a>
        <a class="carousel-item" href="#four"><img src="img/slide/slide4.png"></a>
    </div>

    <!--Create container to display the icecream from database-->   
    <div class="container grey-text">
        <h4 class="center grey-text">Flavor of the Month</h4>
        <div class="row">

            <!--Display data from $icecream_array using foreach loop to loop through data-->
            <?php foreach($icecream_array as $icecream): ?>
                <div class="col s12 m4">
                    <div class="card z-depth-0">

                        <!--Display each icecream image, pull image from img/ic folder referenced by image name in $icecream_array-->
                        <div class="card-image">
                            <img src="img/ic/<?php echo $icecream['image']; ?>.png">
                        </div>

                        <!--Display each icecream title and price-->
                        <div class="card-content center">
                            <h6><?php echo htmlspecialchars($icecream['title']); ?></h6>
                            <p>Price: $<?php echo $icecream['price']; ?></p>                           
                        </div>

                        <!--Create Order Now card action-->
                        <div class="card-action center">

                            <!--Create form for "Order Now"-->
                            <!--Once the user click "Order Now" button, the script will call order.php with icecream id as parameter-->
                            <form action="order.php?id=<?php echo $icecream['id']; ?>" method ="post"> 
                                <input type="submit" name="add" value="ORDER NOW" class="btn brand z-depth-0">  
                            </form> 
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!--Include footer -->
    <?php include 'templates/footer.php'; ?>
</html>