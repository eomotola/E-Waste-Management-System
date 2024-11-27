<?php
// Include database connection file
include('config.php'); // Make sure to create this file to handle database connections

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $area_name = $_POST['area_name'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $postal_code = $_POST['postal_code'];

    // Prepare SQL statement
    $sql = "INSERT INTO locations (area_name, city, state, postal_code) VALUES (?, ?, ?, ?)";
    
    // Prepare and bind
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssss", $area_name, $city, $state, $postal_code);
        
        // Execute the statement
        if ($stmt->execute()) {
            echo "New location added successfully.";
            // Redirect to homepage after 10 seconds
            header("refresh:3;url=index.html"); // Change 'homepage.php' to your actual homepage file
            exit(); // Make sure to exit after setting the header
        } else {
            echo "Error: " . $stmt->error;
        }
        
        // Close statement
        $stmt->close();
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Location</title>
    <link rel="stylesheet" href="location.css">
</head>

<style>

body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        h2 {
            color: #333;
        }
        form {
 
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        label {
            margin-bottom: 5px;
            display: block;
            font-weight: bold;
        }
        input[type="text"] {
            width: 95%;
            padding: 10px;
            margin: 10px 0 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #5cb85c;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #4cae4c;
        }
        .success {
            color: green;
            text-align: center;
            margin-top: 20px;
        }
        .error {
            color: red;
            text-align: center;
            margin-top: 20px;
        }
    </style>
    
<body>


    <form method="post" action="">
        <label for="area_name">fACULTY:</label><br>
        <input type="text" id="area_name" name="area_name" required><br><br>

        <label for="city">DEPARTMERNT</label><br>
        <input type="text" id="city" name="city" required><br><br>

        <label for="state">STATE</label><br>
        <input type="text" id="state" name="state" required><br><br>

        <label for="postal_code">Postal Code:</label><br>
        <input type="text" id="postal_code" name="postal_code"><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
