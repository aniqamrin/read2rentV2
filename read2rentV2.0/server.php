<?php 

session_start();

//database connection
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

//register form
if (isset($_POST['reg_user'])) 
{
  
    // Receiving the values entered and storing
    // in the variables
    // Data sanitization is done to prevent
    // SQL injections
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
	$adress = mysqli_real_escape_string($db, $_POST['adress']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
  
    // Ensuring that the user has not left any input field blank
    // error messages will be displayed for every blank input
    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
	if (empty($adress)) { array_push($errors, "Adress is required"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
  
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
        // Checking if the passwords match
    }
	$sql0 = "SELECT usUsername FROM users WHERE usUsername= '$username'";
    $query0 = mysqli_query($db, $sql0) or die ("Error: " .mysqli_error($db));
	$row0 = mysqli_num_rows($query0);
    if($row0 != 0)
    {
		echo "<script>window.location.href='http://localhost/read2rent/register.php';
				  alert(',the username has been registered by different user');
				 </script>";
    }

	// If the form is error free, then register the user
    if (count($errors) == 0) {
         
        // Password encryption to increase data security
        $password = md5($password_1);
         
        // Inserting data into table
        $query = "INSERT INTO users (usUsername, usEmail, usPassword) 
                  VALUES('$username', '$email', '$password')"; 
         
        mysqli_query($db, $query);
  
        // Storing username of the logged in user,
        // in the session variable
        $_SESSION['username'] = $username;
         
        // Welcome message
        $_SESSION['success'] = "You have logged in";
         
        // Page on which the user will be 
        // redirected after logging in
        header('location:http://localhost/read2rent/dashboard.php'); 
    }
}

// User login
if (isset($_POST['login_user'])) {
     
    // Data sanitization to prevent SQL injection
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
  
    // Error message if the input field is left blank
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
  
    // Checking for the errors
    if (count($errors) == 0) {
         
        // Password matching
        $password = md5($password);
         
        $query = "SELECT * FROM users WHERE username=
                '$username' AND password='$password'";
        $results = mysqli_query($db, $query);
  
        // $results = 1 means that one user with the
        // entered username exists
        if (mysqli_num_rows($results) == 1) {
             
            // Storing username in session variable
            $_SESSION['username'] = $username;
             
            // Welcome message
            $_SESSION['success'] = "You have logged in!";
             
            // Page on which the user is sent
            // to after logging in
            header('location: http://localhost/read2rent/dashboard.php');
        }
        else {
             
            // If the username and password doesn't match
            array_push($errors, "Username or password incorrect"); 
        }
    }
}

	/* close db connection */
?>
