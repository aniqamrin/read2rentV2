<?php
session_start();

// Database connection
$user = "root";
$pass = ""; 
$host = "localhost";
$dbname= "read2rent";
$errors = array(); 
$_SESSION['success'] = "";
$db= mysqli_connect($host, $user, $pass, $dbname);

if (mysqli_connect_errno()) 
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

// Register form
if (isset($_POST['reg_user'])) 
{
    // Data sanitization to prevent SQL injection
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $address = mysqli_real_escape_string($db, $_POST['address']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
  
    // Validation checks
    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($address)) { array_push($errors, "Address is required"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }
    
    // Check if username already exists
    $sql0 = "SELECT usUsername FROM users WHERE usUsername = '$username'";
    $query0 = mysqli_query($db, $sql0) or die ("Error: " . mysqli_error($db));
    $row0 = mysqli_num_rows($query0);
    if ($row0 != 0) {
        echo "<script>window.location.href='http://localhost/read2rent/register.php';
              alert(',the username has been registered by different user');
              </script>";
    }

    // If no errors, register user
    if (count($errors) == 0) {
        // Encrypt password
        $password = md5($password_1);
         
        // Insert user data into database
        $query = "INSERT INTO users (usUsername, usEmail, usPassword, usAddress) 
                  VALUES ('$username', '$email', '$password', '$address')"; 
        mysqli_query($db, $query);
  
        // Store username in session and redirect
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You have logged in";
        header('location:http://localhost/read2rent/dashboard.php'); 
    }
}

// User login
if (isset($_POST['login_user'])) {
    // Data sanitization
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
  
    // Validate inputs
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
  
    // Authenticate user
    if (count($errors) == 0) {
        $password = md5($password); // Encrypt password
        
        // Query to check username and password
        $query = "SELECT * FROM users WHERE usUsername = '$username' AND usPassword = '$password'";
        $results = mysqli_query($db, $query);
  
        if (mysqli_num_rows($results) == 1) {
            $_SESSION['username'] = $username; // Store username in session
            $_SESSION['success'] = "You have logged in!";
            header('location:http://localhost/read2rent/dashboard.php');
        } else {
            array_push($errors, "Username or password incorrect"); 
        }
    }
}

// Close database connection
$db->close();
?>
