<?php
// staff_orders.php

// Database connection
$servername = "localhost";
$username = "root";  // default XAMPP username
$password = "";      // default XAMPP password is empty
$dbname = "read2rent";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle order status updates
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['transID']) && isset($_POST['action'])) {
    $transID = $_POST['transID'];
    $action = $_POST['action'];
    
    // You may want to add more status options based on your business logic
    $new_status = ($action == 'Approve') ? 'Approved' : 'Declined';
    
    // Update the status in the buyrent table
    $sql = "UPDATE buyrent SET status = '$new_status' WHERE transID = $transID";
    $conn->query($sql);
}

// Fetch orders from the database
$sql = "SELECT br.transID, br.transType, u.usUsername, b.bookName, p.payAmount, br.status 
        FROM buyrent br
        JOIN users u ON br.usID = u.usID
        JOIN detail d ON br.transID = d.transID
        JOIN book b ON d.bookID = b.bookID
        JOIN payment p ON br.payID = p.payID
        ORDER BY br.transID DESC";
$result = $conn->query($sql);
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
                    </ul>
                </div>
            </nav>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 my-3">
                <div class="projects mb-4">
                    <div class="projects-inner">
                        <header class="projects-header">
                            <div class="title">Order Management</div>
                        </header>
                        <table class="projects-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Book Title</th>
                                    <th>User</th>
                                    <th>Type</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td><p>" . $row["transID"] . "</p></td>";
                                        echo "<td><p>" . $row["bookName"] . "</p></td>";
                                        echo "<td class='member'><p>" . $row["usUsername"] . "</p></td>";
                                        echo "<td><p>" . $row["transType"] . "</p></td>";
                                        echo "<td><p>RM" . $row["payAmount"] . "</p></td>";
                                        echo "<td class='status'><span class='status-text status-" . strtolower($row["status"]) . "'>" . $row["status"] . "</span></td>";
                                        echo "<td>";
                                        echo "<form class='form' action='' method='POST'>";
                                        echo "<input type='hidden' name='transID' value='" . $row["transID"] . "'>";
                                        echo "<select class='action-box' name='action' onchange='this.form.submit()'>";
                                        echo "<option>Actions</option>";
                                        echo "<option>Approve</option>";
                                        echo "<option>Decline</option>";
                                        echo "</select>";
                                        echo "</form>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No orders found</td></tr>";
                                }
                                ?>
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
<?php
$conn->close();
?>