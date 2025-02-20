<?php
session_start();
require 'authorize.php';
authorize('lawyer');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lawyer Dashboard</title>
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
        <h1 class="text-center">Lawyer Dashboard</h1>
        <div class="auth-form">
            <h2 class="mb-2">Submit New Issue</h2>
            <form method="POST" action="submit_issue.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="content" class="form-control" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label>Issue Type</label>
                    <select name="issue_type" class="form-control" required>
                        <option value="normal">Normal</option>
                        <option value="technical">Technical</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Upload Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit Issue</button>
            </form>
        </div>
    </div>
</body>
</html>