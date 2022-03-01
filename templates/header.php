<?php
 // Use null coalescing to display 'Guest' if $_SESSION is not set.  It it is set, display $_SESSION for the user that is logging in
 $userName = $_SESSION['username'] ?? 'Guest';

 // Count item in the cart session and assign to $itemCount, this $itemCount will be displayed on the cart icon
 if (isset($_SESSION['cart'])) {
     $itemCount = count($_SESSION['cart']);
 } else {
     // if no cart session is set, set $itemCount to 0
     $itemCount = 0;
 }
 ?>
<!--HTML page content-->
<head>
    <!--Let browser know how to read the webpage and how to paste it and show to the user-->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
    
    <title>Ice Cream Shop</title>

    <!--Materialize icons-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
       
    <!--Compiled and minified Materialize CSS-->
    <link type="text/css" rel="stylesheet" media="screen,projection" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    
    <!--Custom css-->
    <style type="text/css">
        .brand{
            background: #cbb09c !important;
        }

        .brand-text{
            color: #cbb09c !important;
        }

        form{
            max-width: 460px;
            margin: 20px auto;
            padding: 20px;
        }

        .font{
            font-size: 16px;           
        }

        .dropdown{
            margin-top: 0px;
        }

        .checkout{
            max-width: 460px;
            margin: 20px auto;
            padding: 20px;
        }

        .icecream{
            width: 150px;
            height: 150px;
            margin: 40px auto -20px;
            display: block;
            position: relative;
            top: -15px;
        }

        .icecream-checkout{
            width: 80px;
            height: 80px;
        }

        .responsive{
            max-width: 100%;
            height: auto;
        }

        .material-icons{ 
            color: black; 
        } 

        .cart{
            width: 25px;
            height: 25px;
            background-image: url('img/cart_icon.png');
            background-size: contain;
            background-repeat: no-repeat;
            margin-left:10px; 
            position: absolute;
            top: 20px;
        }

        .count {
            position: absolute;
            background-color: #A2A0A0;
            border: none;
            color: white !important;
            left: 20px;
            bottom: 10px;
            font-family: sans-serif;
            font-size: 15px;          
            text-align: center;
            vertical-align: middle;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            line-height: 15px;
            padding-top: 8px;     
        }
    </style>    
</head>
<body class="grey lighten-4">   
    <!--Create NavBar-->
    <nav class="nav-wraper white z-depth-0">
        <div class="container">          
            <a href="index.php" class="brand-logo brand-text">Ice Cream Shop</a>  
            
            <!--This is for mobile navbars-->
            <a href="#" data-target="mobile-links" class="sidenav-trigger"><i class="material-icons">menu</i></a>                
            
            <!--This is for tablet, laptop and desktop navbars-->
            <ul class="right hide-on-med-and-down">
                <li class="grey-text">Hello <?php echo htmlspecialchars($userName); ?></li>
                <?php if(empty($_SESSION["loggedin"])): ?>
                    <li><a href ="register.php" class="btn brand z-depth-0">Create Account</a></li>
                    <li><a href ="login.php" class="btn grey z-depth-0">Login</a></li> 
                <?php else: ?>
                    <li><a href="logout.php" class="btn grey z-depth-0">Logout</a></li>
                    <li><a href="password_reset.php" class="btn brand z-depth-0">Reset Password</a></li>                   
                <?php endif; ?>   
                
                <!--Display cart icon, if $itemCount = 0, when user click on the icon, it will take them to cart_empty.php-->
                <!--Otherwise, it will take the user to cart.php-->
                <?php if($itemCount == 0): ?>   
                    <li><a href ="cart_empty.php"><div class="cart"><span class="count"><?php echo $itemCount ?></span></div></a></li>
                <?php else: ?>
                    <li><a href ="cart.php"><div class="cart"><span class="count"><?php echo $itemCount ?></div></li>
                <?php endif; ?>
            </ul>                               
        </div>
    </nav>

    <!--This is for mobile navbars-->
    <ul class="sidenav" id="mobile-links">
        <li class="center grey-text">Hello <?php echo htmlspecialchars($userName); ?></li>
        <?php if(empty($_SESSION["loggedin"])): ?>
            <li><a href ="register.php" class="btn brand z-depth-0">Create Account</a></li>
            <li><a href ="login.php" class="btn grey z-depth-0">Login</a></li> 
        <?php else: ?>
            <li><a href="logout.php" class="btn grey z-depth-0">Logout</a></li>
            <li><a href="password_reset.php" class="btn brand z-depth-0">Reset Password</a></li>                   
        <?php endif; ?>   

        <!--Display cart icon, if $itemCount = 0, when user click on the icon, it will take them to cart_empty.php-->
        <!--Otherwise, it will take the user to cart.php-->   
        <?php if($itemCount == 0): ?>
            <li><a href ="cart_empty.php"><div class="cart"><span class="count"><?php echo $itemCount ?></span></div></a></li>
        <?php else: ?>
            <li><a href ="cart.php"><div class="cart"><span class="count"><?php echo $itemCount ?></span></div></a></li>
        <?php endif; ?>
    </ul>   

