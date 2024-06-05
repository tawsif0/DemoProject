<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $admin_id = $_SESSION['admin_id'];
    $check_sql = "SELECT * FROM dealers WHERE username='$username'";
    $check_result = $conn->query($check_sql);
    if ($check_result->num_rows > 0) {
        echo "<script>alert('Username already exists');</script>";
    } else {
        $sql = "INSERT INTO dealers (username, phone, address, password, admin_id) VALUES ('$username', '$phone', '$address', '$password', '$admin_id')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('New dealer added successfully');</script>"; 
            header('Location: dashboard.php'); 
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Dealer</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Add Dealer</h2>
    <form action="add_dealer.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required>
        <br>
        <label for="address">Address:</label>
        <textarea id="address" name="address" required></textarea>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Add Dealer</button>
    </form>
    <button onclick="goBack()">Go Back</button>
</body>
</html>

<script>
function goBack() {
    window.location.href = "dashboard.php";
}
</script>
