<?php
    // Start the session
    session_start();
     
    // Check if the user already logged in, if yes, redirect user to home page and exit this script
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        header('Location:index.php');
        exit;
    }

    // Connect to database server by calling db_connect.php
    require_once 'config/db_connect.php';

    // Define variables and initialize with empty value
    $username = $password = "";

    // Define $errors array variable, the error value will be assigned in this array dynamically
    $errors = ['username'=>'', 'password'=>'', 'unknown'=>''];

    // Check if the login form has been submitted
    if (isset($_POST["submit"])) {

        // Validate if username empty
        if (empty(trim($_POST["username"]))) {
            $errors['username'] = "Please enter your username.";
        } else {
            $username = trim($_POST["username"]);
        }

        // Validate if password empty
        if (empty(trim($_POST["password"]))) {
            $errors['password'] = "Please enter your password.";
        } else {
            $password = trim($_POST["password"]);
        }

        // If no error found, perform query to get user info from database
        if (!array_filter($errors)) {

            // Prepare and bind a select statement
            $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
            $stmt->bind_param("s", $param_username);

            // Set parameter, assign username the user entered into $param_username
            $param_username = trim($_POST["username"]);

            // If execute success
            if ($stmt->execute()) {

                // Store result
                $stmt->store_result();

                // If username exists, bind and fetch result and then verify password
                if ($stmt->num_rows == 1) {

                    // Bind result variables and fetch the result
                    $stmt->bind_result($id, $username, $hashed_password);
                    if ($stmt->fetch()) {

                        // Use password_verify() function to verify password user entered with hash password
                        if (password_verify($password, $hashed_password)) {
                            
                            // If password is correct, start session for that user
                            session_start();

                            // Assign session variables
                            $_SESSION['loggedin'] = true;
                            $_SESSION['id'] = $id;
                            $_SESSION['username'] = $username;

                            // When user logged in, set the shopping cart sessions to empty in case that user added item to cart prior logged in
                            $_SESSION['cart'] = []; 
                            
                            // Then, redirect user to homepage
                            header('Location: index.php');
                        } else {
                            // If password is not correct, display the error
                            $errors['password'] = "The password you entered is invalid";
                        }
                    }
                } else {
                    // If username does not exist, disply the error
                    $errors['username'] = "No account found with this username";
                }
            } else {
                // If sql statement cannot be executed, display the error
                $errors['unknown'] = "Something went wrong, please try again later";
            }
            // Free result
            $stmt->close();
        }
        // Close connection
        $conn->close();
    }
?>

<!DOCTYPE html>
<html>
    <!--Include header-->
    <?php include 'templates/header.php'; ?>

    <section class="container grey-text">
        <h4 class="center">Login</h4>
        <p class="center">Please fill in your credentials to login</p>
        
        <!--Login form-->
        <form class="white" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method ="post">
            <label>Username:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>">
            <div class="red-text"><?php echo $errors['username']; ?></div>
            <label>Password:</label>
            <input type="password" name="password" value="<?php echo htmlspecialchars($password); ?>">
            <div class="red-text"><?php echo $errors['password']; ?></div>
            <div class="center">
                <div class="red-text"><?php echo $errors['unknown']; ?></div>
                <input type="submit" name="submit" value="submit" class="btn brand z-depth-0"> 
                <p>Don't have an account? <a href="register.php">Sign up now</a></p>          
            </div>
        </form>
    </section>

    <!--Include footer-->
    <?php include 'templates/footer.php'; ?>
</html>
