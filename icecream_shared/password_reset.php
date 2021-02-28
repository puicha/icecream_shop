<?php
    // Start session    
    session_start();

    // Check if the user already logged in, if not, redirect user to login page and exit this script
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header('Location:login.php');
        exit;
    }

    // Connect to the database server by calling db_connect.php
    require_once 'config/db_connect.php';

    // Define variables and initialize with empty value
    $new_password = $confirm_password = "";

    // Create array of errors and initialize with empty value
    $errors = ['new_password'=>'', 'confirm_password'=>''];

    // Check if the form has been submitted
    if(isset($_POST["submit"])){
        
        // Validate new password
        // Check if new password field is empty as well as remove unnecessary characters using trim() function
        if (empty(trim($_POST["new_password"]))) {
            $errors['new_password'] = "Please enter a password.";
        } else {
            $new_password = trim($_POST["new_password"]);

            // Check if new password is less then 6 characters
            if (strlen(trim($_POST["new_password"])) < 6) {
                $errors['new_password'] = "Password must have at least 6 characters.";
            }
        }

        // Validate comfirm password
        // Check if confirm password field is empty as well as remove unnecessary characters using trim() function
        if (empty(trim($_POST["confirm_password"]))) {
            $errors['confirm_password'] = "Please confirm password.";
        } else {
            $confirm_password = trim($_POST["confirm_password"]);

            // Check if password matches
            if ($new_password != $confirm_password) {
                $errors['confirm_password'] = "Password did not match.";
            }
        }
        // If no error found, insert user input in database and then create the session for the user and redirect to homepage
        if (!array_filter($errors)) {

            // Prepare update statement
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->bind_param("si",$param_password, $param_id);

            // Set parameters and create a password hash for password
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION['id'];

            // Execute statement
            if ($stmt->execute()) {                          
                // Then, redirect user to homepage
                header('Location: login.php');
                exit();
            } else {
                // Display error
                echo "query error: ". mysqli_error($conn);
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
        <h4 class="center">Reset Password</h4>
        <p class="center">Please fill out this form to reset your password.</p>
        
        <!--Reset Password Form -->
        <form class="white" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method ="post">
            <label>New Password:</label>
            <input type="password" name="new_password" value="<?php echo htmlspecialchars($new_password); ?>">
            <div class="red-text"><?php echo $errors['new_password']; ?></div>
            <label>Confirm Password:</label>
            <input type="password" name="confirm_password" value="<?php echo htmlspecialchars($confirm_password); ?>">
            <div class="red-text"><?php echo $errors['confirm_password']; ?></div>
            <div class="center">
                <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">           
            </div>
        </form>
    </section>
    
    <!--Include footer-->
    <?php include 'templates/footer.php'; ?>
</html>
