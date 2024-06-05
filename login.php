<?php
session_start();
require 'db.php';


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Database connected successfully.<br>";
}

$username = $_POST['username'];
$password = $_POST['password'];

echo "Username: $username, Password: $password<br>";


$sql = "SELECT * FROM admins WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Username found in admins table.<br>";
    $row = $result->fetch_assoc();
    if ($password == $row['password']) { 
        $_SESSION['admin_id'] = $row['id'];
        $_SESSION['admin_name'] = $row['name'];
        echo "Admin login successful.<br>";
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Admin password does not match.<br>";
    }
} else {
    echo "Username not found in admins table.<br>";
}


$sql = "SELECT * FROM dealers WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Username found in dealers table.<br>";
    $row = $result->fetch_assoc();
    if ($password == $row['password']) { 
        $_SESSION['dealer_id'] = $row['id'];
        $_SESSION['dealer_name'] = $row['username'];
        echo "Dealer login successful.<br>";
        header('Location: dealer_dashboard.php');
        exit();
    } else {
        echo "Dealer password does not match.<br>";
    }
} else {
    echo "Username not found in dealers table.<br>";
}

header('Location: index.php?error=Invalid%20login');
?>
