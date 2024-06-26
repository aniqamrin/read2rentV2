<?php
// Database connection
$user = "root";
$pass = ""; 
$host = "localhost";
$dbname= "read2rent";
$db= mysqli_connect($host, $user, $pass, $dbname);

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

if(isset($_POST['submit'])){
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $genre = trim($_POST['genre']);
    
    // File upload handling
    $image_name = $_FILES['file']['name'];
    $temp_name = $_FILES["file"]["tmp_name"];
    $file_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
    $file_size = $_FILES['file']['size'];
    $allowed_extensions = array("jpeg", "jpg", "png", "gif", "avif");

    // Check file type and size
    if (!in_array($file_extension, $allowed_extensions)) {
        $message = "File type not allowed. Please choose a JPEG, JPG, PNG, GIF, or AVIF file.";
    } elseif ($file_size > 500000) {
        $message = "File size too large. Please choose a file under 500 KB.";
    } else {
        // Move uploaded file to desired location
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/READ2RENT/image/";
        if (move_uploaded_file($temp_name, $upload_dir . $image_name)) {
            // Insert book details into database
            $query = "INSERT INTO book (bookName, bookAuthor, bookGenre, bookImageLocation) 
                      VALUES ('$title', '$author', '$genre', '$image_name')";
            $result = mysqli_query($db, $query);
            if ($result) {
                $message = "Book added successfully.";
                header("Location: addbook.php");
                exit();
            } else {
                $message = "Error: " . mysqli_error($db);
            }
        } else {
            $message = "Failed to upload file.";
        }
    }

    // Display message
    echo '<div style="color:#FF0000;text-align:center;font-size:12px;">' . $message . '</div>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Book - Reads2Rent</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:300,600" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.selectric/1.10.1/selectric.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="staff.css">
</head>
<body>
    <nav class="navbar navbar-dark sticky-top flex-md-nowrap p-0">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Reads2Rent</a>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="#">Sign out</a>
            </li>
        </ul>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="staff.php">
                                <i class="zmdi zmdi-widgets"></i>
                                Staff Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="staffOrders.php">
                                <i class="zmdi zmdi-file-text"></i>
                                Orders <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="addbook.php">
                                <i class="zmdi zmdi-widgets"></i>
                                Add Book <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="deleteBook.php">
                                <i class="zmdi zmdi-file-text"></i>
                                Delete Book <span class="sr-only">(current)</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 my-3">
                <div class="projects mb-4">
                    <div class="projects-inner">
                        <header class="projects-header">
                            <div class="title">Add Book</div>
                        </header>
                        <form method="post" enctype="multipart/form-data">
                            <input type="text" class="form-control" name="title" placeholder="Title" required autofocus />
                            <input type="text" class="form-control" name="author" placeholder="Author" required />
                            <input type="text" class="form-control" name="genre" placeholder="Genre" required />
                            <input type="file" name="file" class="form-control-file mt-3" required />
                            <button class="btn btn-lg btn-primary btn-block mt-3" name="submit" type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js'></script>
    <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js'></script>
    <script src='https://cdn.jsdelivr.net/jquery.selectric/1.10.1/jquery.selectric.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.min.js'></script>
    <script src="./script.js"></script>
</body>
</html>
