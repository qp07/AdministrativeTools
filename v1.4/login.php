<?php
session_start();
$conn = new mysqli("localhost", "root", "", "auth_system");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim(htmlspecialchars($_POST['username']));
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT User_ID, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $hashed_password, $role);
    $stmt->fetch();

    if ($hashed_password && password_verify($password, $hashed_password)) {
        session_regenerate_id(true);
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $user_id; // Store user ID in session
        $_SESSION['role'] = $role;
        header("Location: welcome.php");
        exit;
    } else {
        echo "<div class='container text-center'><p style='color: red;'>Invalid username or password.</p></div>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <ul class="nav-list">
                <li><a href="home.php">Home</a></li>
            </ul>
        </div>
    </nav>
    
    <div class="container">
        <div class="auth-form">
            <h1 class="text-center mb-2">User Login</h1>
            <form method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
        </div>
    </div>
</body>
</html>