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

// Function to get total sold books
function getTotalSoldBooks($pdo) {
    $stmt = $pdo->query("SELECT COUNT(*) FROM buyrent WHERE transType = 'buy'");
    return $stmt->fetchColumn();
}

// Function to get total rent
function getTotalRent($pdo) {
    $stmt = $pdo->query("SELECT SUM(p.payAmount) FROM buyrent b JOIN payment p ON b.payID = p.payID WHERE b.transType = 'rent'");
    return $stmt->fetchColumn() ?: 0;
}

// Function to get total bought
function getTotalBought($pdo) {
    $stmt = $pdo->query("SELECT SUM(p.payAmount) FROM buyrent b JOIN payment p ON b.payID = p.payID WHERE b.transType = 'buy'");
    return $stmt->fetchColumn() ?: 0;
}

// Function to get total books
function getTotalBooks($pdo) {
    $stmt = $pdo->query("SELECT COUNT(*) FROM book");
    return $stmt->fetchColumn();
}

// Function to get transaction data
function getTransactions($pdo) {
    $query = "
        SELECT 
            br.transID,
            b.bookName,
            u.usUsername,
            br.transType,
            p.payAmount,
            br.status
        FROM 
            buyrent br
            JOIN users u ON br.usID = u.usID
            JOIN detail d ON br.transID = d.transID
            JOIN book b ON d.bookID = b.bookID
            JOIN payment p ON br.payID = p.payID
        ORDER BY 
            br.transID DESC
        LIMIT 10
    ";
    $stmt = $pdo->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to update transaction status
function updateTransactionStatus($pdo, $transID, $status) {
    $query = "UPDATE buyrent SET status = :status WHERE transID = :transID";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['status' => $status, 'transID' => $transID]);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && isset($_POST['transID'])) {
    $transID = $_POST['transID'];
    $action = $_POST['action'];
    if ($action === 'Approve' || $action === 'Decline') {
        updateTransactionStatus($pdo, $transID, $action);
    }
}

$totalSoldBooks = getTotalSoldBooks($pdo);
$totalRent = getTotalRent($pdo);
$totalBought = getTotalBought($pdo);
$totalBooks = getTotalBooks($pdo);
$transactions = getTransactions($pdo);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Staff Dashboard</title>
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
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="dashboard.php">Reads2Rent</a>
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
                        <a class="nav-link active" href="staff.php">
                            <i class="zmdi zmdi-widgets"></i>
                            Staff Dashboard <span class="sr-only">(current)</span>
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
                            <a class="nav-link active" href="deleteBook.php">
                                <i class="zmdi zmdi-file-text"></i>
                                Delete Book <span class="sr-only">(current)</span>
                            </a>
                        </li>
                </ul>
            </div>
        </nav>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 my-3">
            <div class="card-list">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4">
                        <div class="card blue">
                            <div class="title">Total Sold Books</div>
                            <i class="zmdi zmdi-upload"></i>
                            <div class="value"><?php echo $totalSoldBooks; ?></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4">
                        <div class="card green">
                            <div class="title">Total Rent</div>
                            <i class="zmdi zmdi-upload"></i>
                            <div class="value"><?php echo $totalRent; ?></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4">
                        <div class="card orange">
                            <div class="title">Total Bought</div>
                            <i class="zmdi zmdi-download"></i>
                            <div class="value"><?php echo $totalBought;?></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4">
                        <div class="card red">
                            <div class="title">Total Books</div>
                            <i class="zmdi zmdi-download"></i>
                            <div class="value"><?php echo $totalBooks; ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="projects mb-4">
                <div class="projects-inner">
                    <header class="projects-header">
                        <div class="title">Recent Transactions</div>
                    </header>
                    <table class="projects-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>User</th>
                                <th>Price</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th class="text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transactions as $transaction): ?>
                                <tr>
                                    <td>
                                        <p><?php echo htmlspecialchars($transaction['transID']); ?></p>
                                    </td>
                                    <td>
                                        <p><?php echo htmlspecialchars($transaction['bookName']); ?></p>
                                    </td>
                                    <td class="member">
                                        <p><?php echo htmlspecialchars($transaction['usUsername']); ?></p>
                                    </td>
                                    <td>
                                        <p>RM<?php echo number_format($transaction['payAmount'], 2); ?></p>
                                    </td>
                                    <td class="status">
                                        <span class="status-text status-<?php echo $transaction['transType'] == 'rent' ? 'orange' : 'blue'; ?>">
                                            <?php echo ucfirst($transaction['transType']); ?>
                                        </span>
                                    </td>
                                    <td class="status">
                                        <span class="status-text status-<?php echo $transaction['status'] == 'Pending' ? 'orange' : ($transaction['status'] == 'Approve' ? 'green' : 'red'); ?>">
                                            <?php echo $transaction['status']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <form class="form" action="" method="POST">
                                            <input type="hidden" name="transID" value="<?php echo $transaction['transID']; ?>">
                                            <select name="action" class="action-box" onchange="this.form.submit()" <?php echo $transaction['status'] != 'Pending' ? 'disabled' : ''; ?>>
                                                <option value="">Actions</option>
                                                <option value="Approve">Approve</option>
                                                <option value="Decline">Decline</option>
                                            </select>
                                        </form>
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
<script>
    // Add this script to prevent form resubmission on page refresh
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
</body>
</html>
