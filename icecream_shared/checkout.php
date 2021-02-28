<?php
    // Start the session
    session_start();

    // Initilize variable
    $subtotal = 0; 

    // Define variables and initialize with empty value
    $firstname = $lastname = $address = $city = $state = $zipcode = $phone = "";
    $cardname = $cardnumber = $expmonth = $expyear = $cvv = "";

    // Define error array variables, the error value will be assigned in these array dynamically
    $infoErrors = ['firstname'=>'', 'lastname'=>'', 'address'=>'', 'city'=>'', 'state'=>'', 'zipcode'=>'', 'phone'=>''];
    $cardErrors = ['cardname'=>'', 'cardnumber'=>'', 'expmonth'=>'', 'expyear'=>'', 'cvv'=>''];
    
    // Check if the checkout form has been submitted
    if (isset($_POST["submit"])) {

        // Validate user inputs
        if (empty(trim($_POST["firstname"]))) {
            $infoErrors['firstname'] = "Please enter your first name.";
        } else {
            $firstname = trim($_POST["firstname"]);
            // Use preg_match function and regex to validate input
            if (!preg_match('/^[a-zA-Z\s]+$/', $firstname)) {
                // Assign error message to 'firstname' array key
                $infoErrors['firstname'] = "First name must be letters and spaces only";
            }
        }

        if (empty(trim($_POST["lastname"]))) {
            $infoErrors['lastname'] = "Please enter your last name.";
        } else {
            $lastname = trim($_POST["lastname"]);
            // Use preg_match function and regex to validate input
            if (!preg_match('/^[a-zA-Z\s]+$/', $lastname)) {
                // Assign error message to 'lastname' array key
                $infoErrors['lastname'] = "Last name must be letters and spaces only";
            }
        }

        if (empty(trim($_POST["address"]))) {
            $infoErrors['address'] = "Please enter your address.";
        } else {
            $address = trim($_POST["address"]);
        }

        if (empty(trim($_POST["city"]))) {
            $infoErrors['city'] = "Please enter your city.";
        } else {
            $city = trim($_POST["city"]);
        }

        if (empty(trim($_POST["state"]))) {
            $infoErrors['state'] = "Please enter state.";
        } else {
            $state = trim($_POST["state"]);
        }

        if (empty(trim($_POST["zipcode"]))) {
            $infoErrors['zipcode'] = "Please enter your zip code.";
        } else {
            $zipcode = trim($_POST["zipcode"]);
            // Use preg_match function and regex to validate input
            if(!preg_match('/^\d{5}$/', $zipcode)){
                // Assign error message to 'zipcode' array key
                $infoErrors['zipcode'] = "Zipcode is not valid";
            }
        }

        if (empty(trim($_POST["phone"]))) {
            $infoErrors['phone'] = "Please enter your phone number.";
        } else {
            $phone = trim($_POST["phone"]);
            // Use preg_match function and regex to validate input
            if (!preg_match('/\d/', $phone)) {
                // Assign error message to 'zipcode' array key
                $infoErrors['phone'] = "Phone number is not valid";
            }
        }

        if (empty(trim($_POST["cardname"]))) {
            $cardErrors['cardname'] = "Please enter your name on card.";
        } else {
            $cardname = trim($_POST["cardname"]);
            // Use preg_match function and regex to validate input
            if (!preg_match('/^[a-zA-Z\s]+$/', $cardname)) {
                // Assign error message to 'cardname' array key
                $cardErrors['cardname'] = "Name must be letters and spaces only";
            }
        }

        if (empty(trim($_POST["cardnumber"]))) {
            $cardErrors['cardnumber'] = "Please enter your card number.";
        } else {
            $cardnumber = trim($_POST["cardnumber"]);
            // Use preg_match function and regex to validate input
            if (!preg_match('/^[\d\s]{13,19}$/', $cardnumber)) {
                // Assign error message to 'cardnumber' array key
                $cardErrors['cardnumber'] = "Card number is not valid";
            }
        }

        if (empty(trim($_POST["expmonth"]))) {
            $cardErrors['expmonth'] = "Please enter your card expiration month.";
        } else {
            $expmonth = trim($_POST["expmonth"]);
            // Use preg_match function and regex to validate input
            if (!preg_match('/^[0-1]{1}\d{1}$/', $expmonth)) {
                // Assign error message to 'expmonth' array key
                $cardErrors['expmonth'] = "Expiration month is not valid";
            }
        }

        if (empty(trim($_POST["expyear"]))) {
            $cardErrors['expyear'] = "Please enter your card expiration year.";
        } else {
            $expyear = trim($_POST["expyear"]);
            // Use preg_match function and regex to validate input
            if (!preg_match('/^\d{4}$/', $expyear)) {
                // Assign error message to 'expyear' array key
                $cardErrors['expyear'] = "Expiration year is not valid";
            }
        }

        if (empty(trim($_POST["cvv"]))) {
            $cardErrors['cvv'] = "Please enter your card cvv.";
        } else {
            $cvv = trim($_POST["cvv"]);
            // Use preg_match function and regex to validate input
            if (!preg_match('/^\d{2,4}$/', $cvv)) {
                // Assign error message to 'cvv' array key
                $cardErrors['cvv'] = "Card cvv is not valid";
            }
        }
        // If no errors found
        if (!array_filter($infoErrors) && !array_filter($cardErrors)) {
            // Then, redirect user to placed_order page
            header('Location: placed_order.php');
        }
    }
?>
<!DOCTYPE html>
<html>
    <!--Include header-->
    <?php include 'templates/header.php'; ?>
    
    <!--Create container with 2 columns-->
    <div class="container grey-text">
        <div class="row">
            <!--The first column displays the form to accept user input for Billing Address and Card Payment-->
            <div class="col s12 m6">                      
                <form class="white" method="post">
                    <h6 class="grey-text">Billing Address:</h6> 
                    <div class="row">
                        <div class="col s6">
                            <label class="font">First Name</label>
                            <input id="first_name" type="text" name="firstname" class="validate" value="<?php echo htmlspecialchars($firstname); ?>">                         
                            <div class="red-text"><?php echo $infoErrors['firstname']; ?></div>
                        </div> 
                        <div class="col s6">
                            <label class="font">Last Name</label>
                            <input id="last_name" type="text" name="lastname" class="validate" value="<?php echo htmlspecialchars($lastname); ?>">                          
                            <div class="red-text"><?php echo $infoErrors['lastname']; ?></div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col s12">
                            <label class="font">Address:</label>
                            <input type="text" name="address" class="validate" value="<?php echo htmlspecialchars($address); ?>">                           
                            <div class="red-text"><?php echo $infoErrors['address']; ?></div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col s12">
                            <label class="font">City:</label>
                            <input type="text" name="city" class="validate" value="<?php echo htmlspecialchars($city); ?>">                       
                            <div class="red-text"><?php echo $infoErrors['city']; ?></div>
                        </div>
                    </div>

                    <div class ="row">
                        <div class="col s12">
                            <label class="font" >State:</label>
                            <input type="text" name="state" class="validate" value="<?php echo htmlspecialchars($state); ?>">                 
                            <div class="red-text"><?php echo $infoErrors['state']; ?></div>
                        </div>
                    </div>
                   
                    <div class ="row">
                        <div class="col s12">
                            <label class="font">Zip Code:</label>
                            <input type="text" name="zipcode" class="validate" maxlength="5" value="<?php echo htmlspecialchars($zipcode); ?>">                           
                            <div class="red-text"><?php echo $infoErrors['zipcode']; ?></div>
                        </div>
                    </div>
                    
                    <div class ="row">
                        <div class="col s12">
                            <label class="font">Phone:</label>
                            <input type="text" name="phone" class="validate" placeholder="xxx-xxx-xxxx" value="<?php echo htmlspecialchars($phone); ?>">                        
                            <div class="red-text"><?php echo $infoErrors['phone']; ?></div>
                        </div>
                    </div>
                    
                    <h6>Payment:</h6>
                    <p>Accepted Cards</p>
                    <div><img src="img/cards.png" style="width:250px;padding-bottom:20px"></div>

                    <div class ="row">
                        <div class="col s12">
                            <label class="font">Name on Card:</label>
                            <input type="text" name="cardname" class="validate" value="<?php echo htmlspecialchars($cardname); ?>">                   
                            <div class="red-text"><?php echo $cardErrors['cardname']; ?></div>
                        </div>
                    </div>
                    
                    <div class ="row">
                        <div class="col s12">
                            <label class="font">Credit Card Number:</label>
                            <input type="text" name="cardnumber" class="validate" maxlength="19" placeholder="xxxx xxxx xxxx xxxx" value="<?php echo htmlspecialchars($cardnumber); ?>">                           
                            <div class="red-text"><?php echo $cardErrors['cardnumber']; ?></div>
                        </div>
                    </div>

                    <div class ="row">
                        <div class="col s12">
                            <label class="font">Exp Month:</label> 
                            <input type="text" name="expmonth" class="validate" maxlength="2" placeholder="MM" value="<?php echo htmlspecialchars($expmonth); ?>">                                 
                            <div class="red-text"><?php echo $cardErrors['expmonth']; ?></div>
                        </div>
                    </div>

                    <div class ="row">
                        <div class="col s12">
                            <label class="font">Exp Year:</label>
                            <input type="text" name="expyear" class="validate" maxlength="4" placeholder="YYYY" value="<?php echo htmlspecialchars($expyear); ?>">                           
                            <div class="red-text"><?php echo $cardErrors['expyear']; ?></div>
                        </div>
                    </div>

                    <div class ="row">
                        <div class="col s12">
                            <label class="font">CVV:</label>
                            <input type="text" name="cvv" class="validate" maxlength="4" value="<?php echo htmlspecialchars($cvv); ?>">                   
                            <div class="red-text"><?php echo $cardErrors['cvv']; ?></div>
                        </div>
                    </div>

                    <div class="row">
                        <label>
                        <input type="checkbox" checked="checked" name="sameaddress" />
                            <span>Shipping address same as billing</span>
                        </label>
                    </div>

                    <div class="row">
                        <div class="center">
                            <input type="submit" name="submit" value="Place Order" class="btn brand z-depth-0">                         
                        </div>
                    </div>
                </form>                
            </div>

            <!--The second column displays the shopping card orders-->
            <div class="col s12 m6">
                <div class="containter white checkout">       
                    <h6 class="center grey-text">Thank you for shopping with us!</h6>
                    <p class="left-align grey-text">Your Items:</p>

                    <!--If 'checkout' session is set, use foreach loop to iterate through the checkout session and display each item in the session-->
                    <?php if(isset($_SESSION['checkout'])): ?>
                    <?php $CheckoutItems = $_SESSION['checkout']; ?> 
                    <?php foreach($CheckoutItems as $CheckoutItem):?>
                        <div class="row">
                            <div class="col s3 m3">
                                <!-- Display the image pulled from img/ic/ folder using image array key as reference-->              
                                <img src="img/ic/<?php echo $CheckoutItem['image']; ?>.png" class="icecream-checkout responsive">
                            </div>
                            <!--Display item, quantity and price-->
                            <div class="col s3 m3">
                                <?php echo htmlspecialchars($CheckoutItem['item']); ?> 
                            </div>
                            <div class="col s3 m3">       
                                <?php echo "QTY: ". $CheckoutItem['count']; ?>
                            </div>
                            <div class="col s3 m3 right-align">
                                <?php echo "$". number_format($CheckoutItem['price'] * $CheckoutItem['count'], 2); ?>
                            </div>
                        </div>
                        <?php
                        // Get the price total for each item and add to subtotal for each iteration
                        $total = $CheckoutItem['price'] * $CheckoutItem['count']; 
                        $subtotal += $total;
                        ?>                  
                    <?php endforeach; ?>
                    <?php endif; ?>

                        <!--Use Materialize divider class to create a line and separate the section-->
                        <div class="divider"></div>

                        <!--Display Subtotal, shipping, sales tax and Order Total-->
                        <div class="row">
                            <div class="col s6 m6 left-align">                               
                                SubTotal:                  
                            </div>
                            <div class="col s6 m6 right-align">                                                   
                                <?php echo "$". number_format($subtotal, 2); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s6 m6 left-align">
                                Estimated Shipping & Handling - Standard:
                            </div>
                            <div class="col s6 m6 right-align">
                                $5.99
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s6 m6 left-align">
                                Sales Tax:
                            </div>
                            <div class="col s6 m6 right-align">
                                <?php $tax = 0.085 * $subtotal;
                                    echo "$". number_format($tax, 2); ?>
                            </div>
                        </div>
            
                        <div class="row">
                            <div class="col s6 m6 left-align">
                                <b>Order Total:</b>
                            </div>
                            <div class="col s6 m6 right-align">
                                <?php $checkoutTotal = $tax + 5.99 + $subtotal;
                                        echo "$". number_format($checkoutTotal, 2); ?>
                            </div>
                        </div>                       
                </div>       
            </div>       
        </div>
    </div>

    <!--Include footer--> 
    <?php include 'templates/footer.php'; ?>
</html>