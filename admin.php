<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include any necessary files or libraries
require_once 'path/to/db_connection.php';
require_once 'path/to/functions.php';

// Retrieve the user's information
$user_id = $_SESSION['user_id'];
$user_query = "SELECT * FROM users WHERE id = ?";
$stmt = mysqli_prepare($connection, $user_query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$user_result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($user_result);

// Retrieve the list of staff members
$staff_query = "SELECT * FROM staff";
$staff_result = mysqli_query($connection, $staff_query);

// Display the admin page
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <header>
        <h1>Welcome, <?php echo $user['username']; ?>!</h1>
    </header>
    
    <main>
        <!-- Add your admin page content here -->
        <h2>Admin Dashboard</h2>
        <!-- Display any necessary admin-specific data or functionality -->
    </main>
    
    <footer>
        <!-- Add any necessary footer content here -->
    </footer>
    
    <!-- Link to the admin.js file -->
    <script src="admin.js"></script>
</body>
</html>