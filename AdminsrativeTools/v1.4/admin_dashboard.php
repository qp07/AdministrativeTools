<?php
session_start();
require 'authorize.php';
authorize('admin');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <ul class="nav-list">
                <li><a href="welcome.php">Home</a></li>
                <li><a href="view_issues.php">View Issues</a></li>
                <li><a href="logout.php" style="color: #e74c3c;">Logout</a></li>
            </ul>
        </div>
    </nav>
    
    <div class="container">
        <h1 class="text-center">Admin Dashboard</h1>
        <div class="dashboard-grid">
            <div class="card">
                <h2>Manage Issues</h2>
                <p>View and manage all submitted issues</p>
                <br>
                <a href="view_issues.php" class="btn btn-primary">View Issues</a>
            </div>
        </div>
    </div>
</body>
</html>