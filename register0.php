<?php
/* include db connection file */
include("dbcon.php");
if(isset($_POST['submit'])){
	/* capture values from HTML form */
	$name = $_POST['name'];
	$username = $_POST['username'];
	$password = $_POST['password'];
    $adress =$_POST['adress'];
    $sql0 = "SELECT usUsername FROM users WHERE usUsername= '$username'";
    $query0 = mysqli_query($dbcon, $sql0) or die ("Error: " .mysqli_error($dbcon));
	$row0 = mysqli_num_rows($query0);
    if($row0 != 0)
    {
		echo "<script>window.location.href='http://localhost/read2rent/register.php';
				  alert(',the username has been registered by different user');
				 </script>";
    }else
    {
	/* execute SQL INSERT command */
	    $sql2 = "INSERT INTO users (usName, usUsername, usPassword, usAdress)
	    VALUES ('$name', '$username', '$password', '$adress')";
	    mysqli_query($dbcon, $sql2) or die ("Error: " . mysqli_error($dbcon));
	    /* display a message */
	    echo "<script>window.location.href='http://localhost/read2rent/dashboard.php';
				alert('registration complete');
	   			</script>";
	}
}else{ echo "not submited";
}

// close if isset()
	/* close db connection */
	mysqli_close($dbcon);
?>
