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

// Check if report ID is provided
if (!isset($_GET["report_id"])) {
    die("Error: Report ID is required.");
}

// Get report details
$report_id = $_GET["report_id"];
$sql = "SELECT * FROM reports WHERE report_id = :report_id";

if ($stmt = $pdo->prepare($sql)) {
    $stmt->bindParam(":report_id", $report_id);
    $stmt->execute();

    // Check if the report exists
    if ($stmt->rowCount() == 1) {
        $report = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        die("Error: Report not found.");
    }
}

// Close the connection
unset($stmt);
unset($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Details</title>
    <link rel="stylesheet" href="wastedetails.css">
</head>
<body>

    <h2>Report Details</h2>

    <p><strong>Report ID:</strong> <?php echo htmlspecialchars($report["report_id"]); ?></p>
    <p><strong>Location:</strong> <?php echo htmlspecialchars($report["location"]); ?></p>
    <p><strong>Description:</strong> <?php echo htmlspecialchars($report["description"]); ?></p>
    <p><strong>Category:</strong> <?php echo htmlspecialchars($report["category"]); ?></p>
    <p><strong>Urgency:</strong> <?php echo htmlspecialchars($report["urgency"]); ?></p>
    <p><strong>Status:</strong> <?php echo htmlspecialchars($report["status"]); ?></p>
    <p><strong>Submission Date:</strong> <?php echo htmlspecialchars($report["created_at"]); ?></p>

    <?php if ($_SESSION["role"] == "admin") { ?>
        <!-- Admin actions for the report -->
        <form action="update_report_status.php" method="post">
            <input type="hidden" name="report_id" value="<?php echo $report["report_id"]; ?>">
            <div class="form-group">
                <label for="status">Update Status</label>
                <select name="status">
                    <option value="Open" <?php echo $report["status"] == 'Open' ? 'selected' : ''; ?>>Open</option>
                    <option value="In Progress" <?php echo $report["status"] == 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                    <option value="Resolved" <?php echo $report["status"] == 'Resolved' ? 'selected' : ''; ?>>Resolved</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit">Update Status</button>
            </div>
        </form>
    <?php } ?>

</body>
</html>
