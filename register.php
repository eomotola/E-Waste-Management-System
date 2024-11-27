<?php
// Include database connection
$dsn = 'mysql:host=localhost;dbname=waste_system;charset=utf8mb4';
$username_db = 'root'; // Replace with your DB username
$password_db = '';     // Replace with your DB password

try {
    $pdo = new PDO($dsn, $username_db, $password_db);
} catch (PDOException $e) {
    die("Error: Could not connect to the database. " . $e->getMessage());
}

// Initialize variables and error messages
$full_name = $email = $password = $confirm_password = $phone_number = $role = "";
$full_name_err = $email_err = $password_err = $confirm_password_err = $phone_number_err = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate full name
    if (empty(trim($_POST["full_name"]))) {
        $full_name_err = "Please enter your full name.";
    } else {
        $full_name = trim($_POST["full_name"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email address.";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address.";
    } else {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = :email");
        $stmt->bindParam(":email", $param_email);
        $param_email = trim($_POST["email"]);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $email_err = "This email is already registered.";
        } else {
            $email = trim($_POST["email"]);
        }
    }

    // Validate phone number
    if (empty(trim($_POST["phone_number"]))) {
        $phone_number_err = "Please enter your phone number.";
    } else {
        $phone_number = trim($_POST["phone_number"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must be at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm your password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password !== $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Validate role
    if (!empty($_POST["role"]) && in_array($_POST["role"], ['user', 'admin'])) {
        $role = $_POST["role"];
    } else {
        $role = 'user'; // Default role
    }

    // If there are no errors, insert the user data into the database
    if (empty($full_name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($phone_number_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO users (full_name, email, phone_number, password, role) VALUES (:full_name, :email, :phone_number, :password, :role)";
        
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement
            $stmt->bindParam(":full_name", $param_full_name);
            $stmt->bindParam(":email", $param_email);
            $stmt->bindParam(":phone_number", $param_phone_number);
            $stmt->bindParam(":password", $param_password);
            $stmt->bindParam(":role", $param_role);
            
            // Set parameters
            $param_full_name = $full_name;
            $param_email = $email;
            $param_phone_number = $phone_number;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password
            $param_role = $role;

            // Execute the prepared statement
            if ($stmt->execute()) {
                // Registration successful, redirect to login page or success page
                header("Location: login.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
    }

    // Close connection
    unset($stmt);
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Now</title>

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
                        <h2>Register Now</h2>
                        <p>Register to access your account</p>

                        <!-- Registration Form -->
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                            <div class="form-group <?php echo (!empty($full_name_err)) ? 'has_error' : ''; ?>">
                                <input type="text" name="full_name" id="full_name" class="form-control" value="<?php echo $full_name; ?>" placeholder="Full Name">
                                <span class="help-block"><?php echo $full_name_err; ?></span>
                            </div>

                            <div class="form-group <?php echo (!empty($email_err)) ? 'has_error' : ''; ?>">
                                <input type="email" name="email" id="email" class="form-control" value="<?php echo $email; ?>" placeholder="Email">
                                <span class="help-block"><?php echo $email_err; ?></span>
                            </div>

                            <div class="form-group <?php echo (!empty($phone_number_err)) ? 'has_error' : ''; ?>">
                                <input type="text" name="phone_number" id="phone_number" class="form-control" value="<?php echo $phone_number; ?>" placeholder="Phone Number">
                                <span class="help-block"><?php echo $phone_number_err; ?></span>
                            </div>

                            <div class="form-group <?php echo (!empty($password_err)) ? 'has_error' : ''; ?>">
                                <input type="password" name="password" id="password" class="form-control" value="<?php echo $password; ?>" placeholder="Password">
                                <span class="help-block"><?php echo $password_err; ?></span>
                            </div>

                            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has_error' : ''; ?>">
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>" placeholder="Confirm Password">
                                <span class="help-block"><?php echo $confirm_password_err; ?></span>
                            </div>

                            <div class="form-group">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="form-control">
                                    <option value="user" <?php echo $role == 'user' ? 'selected' : ''; ?> >User</option>
                                    <option value="admin" <?php echo $role == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                </select>
                            </div>

                            <button name="submit" class="btn" type="submit">Register</button>
                        </form>

                        <div class="social-icons">
                            <p>Have an account? <a href="login.php">Login</a>.</p>
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
