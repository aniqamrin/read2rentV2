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

// Function to get user's purchased books
function getUserPurchasedBooks($pdo, $userID) {
    $stmt = $pdo->prepare("
        SELECT 
            b.bookName,
            p.payAmount,
            br.transType,
            br.status
        FROM 
            buyrent br
            JOIN detail d ON br.transID = d.transID
            JOIN book b ON d.bookID = b.bookID
            JOIN payment p ON br.payID = p.payID
        WHERE 
            br.usID = :userID AND br.transType = 'buy'
    ");
    $stmt->execute(['userID' => $userID]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get user's rented books
function getUserRentedBooks($pdo, $userID) {
    $stmt = $pdo->prepare("
        SELECT 
            b.bookName,
            p.payAmount,
            br.transType,
            br.status
        FROM 
            buyrent br
            JOIN detail d ON br.transID = d.transID
            JOIN book b ON d.bookID = b.bookID
            JOIN payment p ON br.payID = p.payID
        WHERE 
            br.usID = :userID AND br.transType = 'rent'
    ");
    $stmt->execute(['userID' => $userID]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Assuming user ID is stored in session
session_start();
$userID = $_SESSION['userID'];

$purchasedBooks = getUserPurchasedBooks($pdo, $userID);
$rentedBooks = getUserRentedBooks($pdo, $userID);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Dashboard</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:300,600" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/jquery.selectric/1.10.1/selectric.css'>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css'>
  <link rel="stylesheet" href="./style.css">
  <link rel="stylesheet" href="user.css">
</head>
<body>
<nav class="navbar navbar-dark sticky-top flex-md-nowrap p-0">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Reads2Rent</a>
    <ul class="navbar-nav px-3 d-flex flex-row">
        <li class="nav-item text-nowrap" style="margin-right: 10px;">
            <a class="nav-link" href="dashboard.php">Home</a> 
        </li>
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="login.php">Sign out</a>
        </li>
    </ul>
</nav>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class="zmdi zmdi-widgets"></i>
                            User Dashboard <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="userOrders.php">
                            <i class="zmdi zmdi-file-text"></i>
                            My Orders
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 my-3">
            <div class="projects mb-4">
                <div class="projects-inner">
                    <header class="projects-header">
                        <div class="title">Purchased Books</div>
                    </header>
                    <table class="projects-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Price</th>
                                <th>Type</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($purchasedBooks as $book): ?>
                                <tr>
                                    <td>
                                        <p><?php echo htmlspecialchars($book['bookName']); ?></p>
                                    </td>
                                    <td>
                                        <p>RM<?php echo number_format($book['payAmount'], 2); ?></p>
                                    </td>
                                    <td class="status">
                                        <span class="status-text status-blue">
                                            <?php echo ucfirst($book['transType']); ?>
                                        </span>
                                    </td>
                                    <td class="status">
                                        <span class="status-text status-<?php echo $book['status'] == 'Pending' ? 'orange' : ($book['status'] == 'Approve' ? 'green' : 'red'); ?>">
                                            <?php echo $book['status']; ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="projects mb-4">
                <div class="projects-inner">
                    <header class="projects-header">
                        <div class="title">Rented Books</div>
                    </header>
                    <table class="projects-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Price</th>
                                <th>Type</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rentedBooks as $book): ?>
                                <tr>
                                    <td>
                                        <p><?php echo htmlspecialchars($book['bookName']); ?></p>
                                    </td>
                                    <td>
                                        <p>RM<?php echo number_format($book['payAmount'], 2); ?></p>
                                    </td>
                                    <td class="status">
                                        <span class="status-text status-orange">
                                            <?php echo ucfirst($book['transType']); ?>
                                        </span>
                                    </td>
                                    <td class="status">
                                        <span class="status-text status-<?php echo $book['status'] == 'Pending' ? 'orange' : ($book['status'] == 'Approve' ? 'green' : 'red'); ?>">
                                            <?php echo $book['status']; ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
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
