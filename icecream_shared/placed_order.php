<?php
    // Start the session
    session_start();

    // Unset cart session
    unset($_SESSION['cart']); 
?>

<!DOCTYPE html>
<html>
    <!--Include header-->
    <?php include 'templates/header.php'; ?>

    <h4 class="center grey-text">Your Order Has Been Placed</h4>
    <h6 class="center grey-text">Thank you for shopping with us!</h6>

    <!--Include footer--> 
    <?php include 'templates/footer.php'; ?>
</html>