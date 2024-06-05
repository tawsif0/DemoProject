<?php
session_start();
require 'db.php';

if (!isset($_SESSION['dealer_id'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dealer_id = $_SESSION['dealer_id'];
    $product_id = $_POST['product_id'];

    $sql = "SELECT * FROM purchases WHERE dealer_id='$dealer_id' AND product_id='$product_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<script>alert('You have already bought this product');</script>";
    } else {
        $sql = "SELECT * FROM products WHERE id='$product_id' AND admin_id = (SELECT admin_id FROM dealers WHERE id='$dealer_id')";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $total_price = $product['price'];

            
            $purchase_timestamp = time();

            $sql = "INSERT INTO purchases (dealer_id, product_id, total_price, purchase_timestamp) VALUES ('$dealer_id', '$product_id', '$total_price', '$purchase_timestamp')";
            if ($conn->query($sql) === TRUE) {
                $admin_id = $product['admin_id'];
                $commission_to_creator = $total_price * 0.02;
                $commission_to_other_admins = $total_price * 0.01;

                $sql = "INSERT INTO commissions (admin_id, dealer_id, product_id, commission_amount, commission_timestamp) VALUES ('$admin_id', '$dealer_id', '$product_id', '$commission_to_creator', '$purchase_timestamp')";
                $conn->query($sql);

                
                $expiry_timestamp = $purchase_timestamp + (150 * 24 * 60 * 60);

                $sql = "SELECT id FROM admins WHERE id <> '$admin_id'";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $other_admin_id = $row['id'];
                    $sql = "INSERT INTO commissions (admin_id, dealer_id, product_id, commission_amount, commission_timestamp) VALUES ('$other_admin_id', '$dealer_id', '$product_id', '$commission_to_other_admins', '$expiry_timestamp')";
                    $conn->query($sql);
                }

                echo "<script>alert('Purchase successful');</script>";
                header('Location: dealer_dashboard.php');
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "<script>alert('Product not found or not added by your creator admin');</script>";
        }
    }
}

$sql = "SELECT * FROM products WHERE admin_id = (SELECT admin_id FROM dealers WHERE id='{$_SESSION['dealer_id']}')";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buy Product</title>
    <link rel="stylesheet" href="./styles.css">
</head>
<body>
    <h2>Buy Product</h2>
    <form action="buy_product.php" method="post">
        <label for="product">Product:</label>
        <select id="product" name="product_id" required>
            <?php if ($result->num_rows > 0) { ?>
                <?php while ($product = $result->fetch_assoc()) { ?>
                    <option value="<?php echo $product['id']; ?>"><?php echo $product['name']; ?> - $<?php echo $product['price']; ?></option>
                <?php } ?>
            <?php } else { ?>
                <option value="">No products found</option>
            <?php } ?>
        </select>
        <br>
        <button type="submit">Buy</button>
    </form>
    <button onclick="goBack()">Go Back</button>
</body>
</html>

<script>
function goBack() {
    window.location.href = 'dealer_dashboard.php';
}
</script>
