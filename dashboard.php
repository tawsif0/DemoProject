<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}
require 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo $_SESSION['admin_name']; ?>!</h2>
        <nav>
            <ul>
                <li><a href="add_dealer.php">Add Dealer</a></li>
                <li><a href="add_product.php">Add Product</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>

        <h3>Dealers</h3>
        <table>
            <thead>
                <tr>
                    <th>Dealer ID</th>
                    <th>Username</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Added By (Admin ID)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM dealers";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['phone'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td>" . $row['admin_id'] . "</td>"; 
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No dealers found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h3>Products</h3>
        <table>
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Added By (Admin ID)</th>
                </tr>
            </thead>
            <tbody>
            
                <?php
                $sql = "SELECT * FROM products";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>$" . $row['price'] . "</td>";
                        echo "<td>" . $row['admin_id'] . "</td>"; 
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No products found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h3>Commissions</h3>
        <table>
            <thead>
                <tr>
                    
                    <th>Dealer ID</th>
                    <th>Product ID</th>
                    <th>Commission Amount</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                     $admin_id = $_SESSION['admin_id'];
                    $sql = "SELECT * FROM commissions WHERE admin_id='$admin_id'";
           
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['dealer_id'] . "</td>";
                        echo "<td>" . $row['product_id'] . "</td>";
                        echo "<td>$" . $row['commission_amount'] . "</td>";
                        
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No commissions found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
