<?php
// Start session
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit;
}

// Include database connection
$dsn = 'mysql:host=localhost;dbname=waste_system;charset=utf8mb4';
$username_db = 'root';
$password_db = '';

try {
    $pdo = new PDO($dsn, $username_db, $password_db);
} catch (PDOException $e) {
    die("Error: Could not connect to the database. " . $e->getMessage());
}

// Initialize variables and error messages
$location = $description = $category = $urgency = $image_path = "";
$location_err = $description_err = $category_err = $urgency_err = $image_err = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate location
    if (empty(trim($_POST["location"]))) {
        $location_err = "Please enter a location.";
    } else {
        $location = trim($_POST["location"]);
    }

    // Validate description
    if (empty(trim($_POST["description"]))) {
        $description_err = "Please enter a description.";
    } else {
        $description = trim($_POST["description"]);
    }

    // Validate category
    if (empty($_POST["category"])) {
        $category_err = "Please select a waste category.";
    } else {
        $category = $_POST["category"];
    }

    // Validate urgency
    if (empty($_POST["urgency"])) {
        $urgency_err = "Please select the urgency level.";
    } else {
        $urgency = $_POST["urgency"];
    }

    // Image upload handling
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check file type (allow only images)
        $allowed_types = array("jpg", "jpeg", "png", "gif");
        if (!in_array($imageFileType, $allowed_types)) {
            $image_err = "Only JPG, JPEG, PNG, and GIF files are allowed.";
        }

        // Move uploaded file to the target directory
        if (empty($image_err)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_path = $target_file;
            } else {
                $image_err = "There was an error uploading the file.";
            }
        }
    } else {
        $image_err = "Please upload an image.";
    }

    // If there are no errors, insert the report data into the database
    if (empty($location_err) && empty($description_err) && empty($category_err) && empty($urgency_err) && empty($image_err)) {
        $sql = "INSERT INTO reports (user_id, location, description, category, urgency, image, status) 
                VALUES (:user_id, :location, :description, :category, :urgency, :image, 'Open')";
        
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement
            $stmt->bindParam(":user_id", $param_user_id);
            $stmt->bindParam(":location", $param_location);
            $stmt->bindParam(":description", $param_description);
            $stmt->bindParam(":category", $param_category);
            $stmt->bindParam(":urgency", $param_urgency);
            $stmt->bindParam(":image", $param_image);
            
            // Set parameters
            $param_user_id = $_SESSION["user_id"];
            $param_location = $location;
            $param_description = $description;
            $param_category = $category;
            $param_urgency = $urgency;
            $param_image = $image_path;

            // Execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to dashboard or success page
                header("Location: locationdetails.php");
                exit;
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
    <title>Submit Waste Report</title>
    <link rel="stylesheet" href="reportwaste.css">
</head>
<body>
    <header>
        <a href="#" class="logo">
            <img src="img/Group 25 1.png">
        </a>
        <div class="button">
            <a href="index.html">BACK TO HOME</a>
        </div>
    </header>

    <section class="waste">
        <div class="waste-title">
            <h2>Waste Reporting Form</h2>
            <p>Please fill in this form to submit a waste report.</p>
        </div>
        <div class="waste-form">

        <div class="waste-img">
        <img src="img/pexels-matreding-9469167 1.png">
    </div>
    
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Location</label>
                    <input type="text" name="location" value="<?php echo $location; ?>">
                    <span><?php echo $location_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description"><?php echo $description; ?></textarea>
                    <span><?php echo $description_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Waste Category</label>
                    <select name="category">
                        <option value="Electronic" <?php echo $category == 'Electronic' ? 'selected' : ''; ?>>Electronic</option>
                        <option value="Household" <?php echo $category == 'Household' ? 'selected' : ''; ?>>Household</option>
                        <option value="Hazardous" <?php echo $category == 'Hazardous' ? 'selected' : ''; ?>>Hazardous</option>
                    </select>
                    <span><?php echo $category_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Urgency</label>
                    <select name="urgency">
                        <option value="Low" <?php echo $urgency == 'Low' ? 'selected' : ''; ?>>Low</option>
                        <option value="Medium" <?php echo $urgency == 'Medium' ? 'selected' : ''; ?>>Medium</option>
                        <option value="High" <?php echo $urgency == 'High' ? 'selected' : ''; ?>>High</option>
                    </select>
                    <span><?php echo $urgency_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Upload Image</label>
                    <input type="file" name="image" accept="image/*">
                    <span><?php echo $image_err; ?></span>
                </div>
                <div class="form-group">
                    <button type="submit">Submit Report</button>
                </div>
            </form>
        </div>
    </section>
</body>
</html>
