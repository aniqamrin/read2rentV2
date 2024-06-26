<?php
// Database connection
$user = "root";
$pass = ""; 
$host = "localhost";
$dbname= "read2rent";
$password = '';
$db= mysqli_connect($host, $user, $pass, $dbname);
if(isset($_POST['submit'])){
    $id = trim($_POST['id']);
    $id = mysqli_real_escape_string($db, $id);

    $title = trim($_POST['title']);
    $title = mysqli_real_escape_string($db, $title);

    $author = trim($_POST['author']);
    $author = mysqli_real_escape_string($db, $author);

    $genre = trim($_POST['genre']);
    $genre = mysqli_real_escape_string($db, $genre);
    $query = "UPDATE book SET bookName='$title',bookGenre='$genre',bookAuthor='$author',bookImageLocation='$image' WHERE bookID='$id'"; 
    $query0 = mysqli_query($db, $query) or die ("Error: " .mysqli_error($db));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Orders - Reads2Rent</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:300,600" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/jquery.selectric/1.10.1/selectric.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css'>
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
                            <a class="nav-link active" href="staff_orders.php">
                                <i class="zmdi zmdi-file-text"></i>
                                Orders <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="addBook.php">
                                <i class="zmdi zmdi-file-text"></i>
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
            </nav><div class="title">update book</div>
                        </header>
                        <form  method="post" >
                            <input type="text" class="form-control" name="id" placeholder="book to update(insert the book id)" required="" autofocus="" />
                            <input type="text" class="form-control" name="title" placeholder="title" autofocus="" />
                            <input type="text" class="form-control" name="author" placeholder="author" />
                            <input type="text" class="form-control" name="genre" placeholder="genre"/>
                            <input type="file" class="form-control" id="fileToUpload" name="fileToUpload" placeholder="file" />
                                <input class="btn btn-lg btn-primary btn-block" value="submit" name="submit" type="submit">
                        </form>
                    </div>
    
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
<?php
$conn->close();
?>