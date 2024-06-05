<?php
session_start();
require 'db.php';

if (!isset($_SESSION['dealer_id'])) {
    header('Location: index.php');
    exit();
}

$dealer_id = $_SESSION['dealer_id'];

$sql = "SELECT * FROM dealers WHERE id='$dealer_id'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $dealer_info = $result->fetch_assoc();
} else {
    echo "Dealer not found";
    exit();
}

$sql = "SELECT * FROM purchases WHERE dealer_id='$dealer_id'";
$purchases_result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dealer Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo $_SESSION['dealer_name']; ?>!</h2>
        <nav>
            <ul>
                
                <li><a href="buy_product.php">Buy product</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>

        <h3>Your Information</h3>
        <p><strong>Name:</strong> <?php echo $_SESSION['dealer_name']; ?></p>
        <p><strong>Phone:</strong> <?php echo $dealer_info['phone']; ?></p>
        <p><strong>Address:</strong> <?php echo $dealer_info['address']; ?></p>

        <h3>Purchase History</h3>
        <table>
            <thead>
                <tr>
                    <th>Product id</th>
                    <th>Total Price</th>
                    <th>Purchase Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($purchases_result->num_rows > 0) {
                    while ($purchase = $purchases_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $purchase['product_id'] . "</td>";
                        echo "<td>$" . $purchase['total_price'] . "</td>";
                        echo "<td>" . $purchase['purchase_date'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No purchases found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
