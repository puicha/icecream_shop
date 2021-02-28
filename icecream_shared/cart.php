<?php
    // Start the session
    session_start();

    // Create checkout session, this session will contain the items user ordered and will be used in checkout page
    $_SESSION['checkout'] = [];

    // Call db_connect.php to connect to database
    require_once 'config/db_connect.php';
?>

<!DOCTYPE html>
<html>
    <!--Include header-->
    <?php include 'templates/header.php'; ?>
    &nbsp;
    
    <!--Create container to display the items in the cart-->
    <div class="container center grey-text">
                      
        <h5 class="left-align grey-text">Items in Shopping Bag</h5>
                        
        <!--If cart_dup session is set and has item in the cart_dup session, iterate the item in the cart_dup using foreach-->
        <?php if(isset($_SESSION['cart_dup']) && count($_SESSION['cart_dup']) != 0): ?>
        <?php $items = $_SESSION['cart_dup']; ?>
        <?php foreach($items as $item => $count): ?>
        <div class="row">
            <div class="col s3 m3">
                <?php
                    // Query SELECT statement to get the item's title, price and image from database
                    $sql = "SELECT title, price, image FROM icecream WHERE id = $item";
                    $result = $conn->query($sql);

                    // Fetch result to $products array, use MYSQLI_ASSOC option for associative array
                    $products = $result->fetch_all(MYSQLI_ASSOC);                     
                ?>

                <!--Display the image pulled from img/ic/ folder using image name in $product array as reference-->              
                <img src="img/ic/<?php echo $products[0]['image']; ?>.png" class="icecream responsive">
            </div>
            <div class="col s3 m3">
                <!--Display product title-->
                <p><?php echo htmlspecialchars($products[0]['title']); ?></p>
            </div>
            <div class="col s3 m3">
                <!--Display quantity-->          
                <p><?php echo "QTY: ". $count; ?></p>
            </div>
            <div class="col s3 m3">
                <!--Display price * quantity-->
                <p><?php echo "$". number_format($products[0]['price'] * $count, 2); ?></p>
            </div>               
        </div>
        <?php
            // For each item in the cart, assign to $itemCheckOut array, then add it to checkout session
            $itemsCheckOut = ["item"=> $products[0]['title'], "price"=> $products[0]['price'], "count"=>$count, "image"=>$products[0]['image']]; 
            array_push($_SESSION['checkout'], $itemsCheckOut);
            endforeach; 
            
            // Free result set
            $result->free_result();
            
            // Close connection
            $conn->close();
            endif;                 
        ?>
        &nbsp;
        <p><a href="index.php" class="left-align btn brand z-depth-0">Continue Shopping</a>
        <a href="cart_reset.php" class="right-align btn grey z-depth-0">Reset Your Cart</a></p>
        <p><a href="checkout.php" class="right-align btn grey darken-3 z-depth-0">Proceed to Check Out</a></p>     
    </div> 

    <!--Include footer--> 
    <?php include 'templates/footer.php'; ?>
</html>