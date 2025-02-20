<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: welcome.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <ul class="nav-list">
                <li><a href="login.php">Login</a></li>
                <li><a href="registration.php">Register</a></li>
            </ul>
        </div>
    </nav>
    
    <div class="container text-center mt-2">
        <h1>Welcome to the Judicial Portal</h1>
        <div class="dashboard-grid mt-2">
            <div class="card">
                <h2>Existing User?</h2>
                <br>
                <a href="login.php" class="btn btn-primary">Login</a>
            </div>
            <div class="card">
                <h2>New User?</h2>
                <br>
                <a href="registration.php" class="btn btn-primary">Register</a>
            </div>
        </div>
    </div>
</body>
</html>