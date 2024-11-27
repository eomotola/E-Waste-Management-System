<?php
// Initialize session
session_start();

// Include database connection
$dsn = 'mysql:host=localhost;dbname=waste_system;charset=utf8mb4';
$username_db = 'root'; // Replace with your DB username
$password_db = '';     // Replace with your DB password

try {
    $pdo = new PDO($dsn, $username_db, $password_db);
} catch (PDOException $e) {
    die("Error: Could not connect to the database. " . $e->getMessage());
}

// Initialize variables
$email = $password = "";
$email_err = $password_err = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check if there are no errors
    if (empty($email_err) && empty($password_err)) {
        // Prepare a select statement to find the user by email
        $sql = "SELECT user_id, full_name, email, password, role FROM users WHERE email = :email";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement
            $stmt->bindParam(":email", $param_email);
            $param_email = $email;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Check if the email exists
                if ($stmt->rowCount() == 1) {
                    // Fetch result as an associative array
                    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $user_id = $row["user_id"];
                        $full_name = $row["full_name"];
                        $email = $row["email"];
                        $hashed_password = $row["password"];
                        $role = $row["role"];

                        // Verify the password
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["user_id"] = $user_id;
                            $_SESSION["full_name"] = $full_name;
                            $_SESSION["role"] = $role;

                            // Redirect user to the appropriate dashboard
                            if ($role == 'admin') {
                                header("Location: dashboard.php");
                            } else {
                                header("Location: reportwaste.php");
                            }
                        } else {
                            // Password is incorrect
                            $password_err = "The password you entered is incorrect.";
                        }
                    }
                } else {
                    // Email doesn't exist
                    $email_err = "No account found with that email.";
                }
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close the statement
        unset($stmt);
    }

    // Close the connection
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>

    <!-- form section start -->
    <section class="w3l-mockup-form">
        <div class="container">
            <!-- /form -->
            <div class="workinghny-form-grid">
                <div class="main-mockup">
                    <div class="w3l_form align-self">
                        <div class="left_grid_info">
                            <!-- Add your image or info here -->
                        </div>
                    </div>
                    <div class="content-wthree">
                        <h2>Login</h2>
                        <p>Login to access your account.</p>

                        <!-- Login Form -->
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                            <div class="form-group <?php echo (!empty($email_err)) ? 'has_error' : ''; ?>">
                                <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" placeholder="Email">
                                <span class="help-block"><?php echo $email_err; ?></span>
                            </div>

                            <div class="form-group <?php echo (!empty($password_err)) ? 'has_error' : ''; ?>">
                                <input type="password" name="password" id="password" class="form-control" value="<?php echo htmlspecialchars($password); ?>" placeholder="Password">
                                <span class="help-block"><?php echo $password_err; ?></span>
                            </div>

                            <button name="submit" class="btn" type="submit">Login</button>
                        </form>

                        <div class="social-icons">
                            <p>Don't have an account? <a href="register.php">Register</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>
    <!-- //form section end -->

    <script src="jquery.min.js"></script>
</body>
</html>
