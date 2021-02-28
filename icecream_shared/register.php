<?php
    // Start session
    session_start();

    // Check if the user already logged in, if yes, redirect user to home page and exit this script
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        header('Location:index.php');
        exit;
    }
    
    // Connect to the database by calling db_connect.php
    require_once 'config/db_connect.php';

    // Define variables and initialize with empty value
    $username = $password = $confirm_password = "";

    // Create array of errors and initialize with empty value
    $errors = ['username'=>'', 'password'=>'', 'confirm_password'=>'', 'unknown'=>''];

    // Check if the form has been submitted
    if (isset($_POST["submit"])) {

        // Validate username
        // Check if username field is empty as well as remove unnecessary characters using trim() function
        if (empty(trim($_POST["username"]))) {
            $errors['username'] = "Please enter a username.";
        } else {
            // Prepare and bind a select statement to check if username already been taken
            $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->bind_param("s", $param_username);
            
            // Set parameter, get username that user entered and assign to $param_username
            $param_username = trim($_POST["username"]);
            
            // Execute statement
            if ($stmt->execute()) {

                // Store result
                $stmt->store_result();
                
                // If username exist, notify user that the username already been taken, otherwise assign to $username
                if ($stmt->num_rows == 1 ) {
                    $errors['username'] = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                // If sql statement cannot be executed, display the error
                $errors['unknown'] = "Something went wrong, please try again later";
            }
            $stmt->close();
        } 

        // Validate password
        // Check if password field is empty as well as remove unnecessary characters using trim() function
        if (empty(trim($_POST["password"]))) {
            $errors['password'] = "Please enter a password.";
        } else {
            $password = trim($_POST["password"]);
            // Check if password is less then 6 characters
            if(strlen(trim($_POST["password"])) < 6){
                $errors['password'] = "Password must have at least 6 characters.";
            }
        }

        // Validate comfirm password
        // Check if password field is empty as well as remove unnecessary characters using trim() function
        if (empty(trim($_POST["confirm_password"]))) {
            $errors['confirm_password'] = "Please confirm password.";
        } else {
            $confirm_password = trim($_POST["confirm_password"]);
            // Check if password matches
            if ($password != $confirm_password) {
                $errors['confirm_password'] = "Password did not match.";
            }
        }

        // If no error found, insert user input in database and then create the session for the user and redirect to homepage
        if(!array_filter($errors)){

            // Prepare and bind insert statement
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?,?)");
            $stmt->bind_param("ss",$param_username, $param_password);

            // Set parameters for username
            $param_username = $username;

            // Creates a password hash and set parameters for password
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            // Execute statement
            if ($stmt->execute()) {

                // Start the session
                session_start();

                // Assign session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $id;
                $_SESSION["username"] = $username;
                           
                // Then, redirect user to homepage
                header('Location: index.php');
            } else {
                // If sql statement cannot be executed, display the error
                $errors['unknown'] = "Something went wrong, please try again later";
            }
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
        <h4 class="center">Create Account</h4>
        
        <!--Account Registration form -->
        <form class="white" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method ="post">
            <label>Username:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>">
            <div class="red-text"><?php echo $errors['username']; ?></div>
            <label>Password:</label>
            <input type="password" name="password" value="<?php echo htmlspecialchars($password); ?>">
            <div class="red-text"><?php echo $errors['password']; ?></div>
            <label>Confirm Password:</label>
            <input type="password" name="confirm_password" value="<?php echo htmlspecialchars($confirm_password); ?>">
            <div class="red-text"><?php echo $errors['confirm_password']; ?></div>
            <div class="center">
                <div class="red-text"><?php echo $errors['unknown']; ?></div>
                <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
                <input type="reset" name="reset" value="reset" class="btn grey z-depth-0">  
                <p>Already have an account<a href="login.php">Login here</a></p>         
            </div>
        </form>
    </section>
    
    <!--Include footer-->
    <?php include 'templates/footer.php'; ?>
</html>