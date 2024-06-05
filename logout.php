<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logout</title>
    <script>
        
        window.onload = function() {
            alert("You have been logged out.");
            window.location.href = "index.php"; 
        };
    </script>
</head>
<body>
</body>
</html>
