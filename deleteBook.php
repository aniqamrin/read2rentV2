<?php
// Database connection
$host = 'localhost';
$dbname = 'read2rent';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

// Fetch books from the database
$query = "SELECT bookID, bookName FROM book ORDER BY bookName";
$stmt = $pdo->query($query);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $bookID = $_POST['bookID'];
    
    // Prepare and execute SQL delete statement
    $stmt = $pdo->prepare("DELETE FROM book WHERE bookID = :bookID");
    $stmt->execute(['bookID' => $bookID]);
    
    // Optionally, you can check if the delete operation was successful
    $deleted = $stmt->rowCount() > 0 ? true : false;
    
    // Display success or error message
    if ($deleted) {
        $message = "Book deleted successfully.";
    } else {
        $message = "Failed to delete book.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Book - Reads2Rent</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:300,600" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.selectric/1.10.1/selectric.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="staff.css">
    <style>
        main h2 {
            color: white;
        }
    </style>
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
                            <a class="nav-link" href="staffOrders.php">
                                <i class="zmdi zmdi-file-text"></i>
                                Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="addbook.php">
                                <i class="zmdi zmdi-widgets"></i>
                                Add Book
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="zmdi zmdi-delete"></i>
                                Delete Book <span class="sr-only">(current)</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 my-3">
                <h2>Delete Book</h2>
                <?php if (isset($message)): ?>
                    <div class="alert alert-<?php echo $deleted ? 'success' : 'danger'; ?>" role="alert">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
                <form method="POST">
                    <div class="form-group">
                        <label for="bookID">Book to Delete:</label>
                        <select class="form-control" id="bookID" name="bookID">
                            <?php foreach ($books as $book): ?>
                                <option value="<?php echo $book['bookID']; ?>"><?php echo htmlspecialchars($book['bookName']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                </form>
            </main>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>