<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $admin_id = $_SESSION['admin_id'];

    $sql = "INSERT INTO products (name, price, admin_id) VALUES ('$name', '$price', '$admin_id')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New product added successfully');</script>"; 
        header('Location: dashboard.php'); 
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link rel="stylesheet" href="./styles.css">
</head>
<body>
    <h2>Add Product</h2>
    <form action="add_product.php" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br>
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" required>
        <br>
        <button type="submit">Add Product</button>
    </form>
    <button onclick="goBack()">Go Back</button>
</body>
</html>

<script>
function goBack() {
    windowlocation.href = "dashboard.php";
}
</script>
