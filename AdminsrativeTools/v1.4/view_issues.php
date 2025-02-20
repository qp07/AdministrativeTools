<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "auth_system");

if ($_SESSION['role'] === 'admin') {
    $query = "SELECT * FROM issues";
    $result = $conn->query($query);
} else {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT * FROM issues WHERE User_ID = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Submitted Issues</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <ul class="nav-list">
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="logout.php" style="color: #e74c3c;">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1 class="text-center mb-2">Submitted Issues</h1>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="issue-card">
                <h3>Issue #<?= $row['Issue_ID'] ?></h3>
                <p><strong>Submitted on:</strong> <?= $row['Date'] ?></p>
                <p><strong>Status:</strong> 
                    <span class="status-badge status-<?= $row['Issue_state'] ?>">
                        <?= ucfirst($row['Issue_state']) ?>
                    </span>
                </p>
                <p><strong>Type:</strong> <?= ucfirst($row['Issue_type']) ?></p>
                <div class="content-box">
                    <?= nl2br($row['Content']) ?>
                </div>
                <?php if ($row['image']): ?>
                    <div class="mt-2">
                        <img src="data:image/jpeg;base64,<?= base64_encode($row['image']) ?>" 
                            class="issue-image" 
                            alt="Issue Attachment">
                    </div>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
        <div class="text-center mt-2">
            <a href="admin_dashboard.php" class="btn btn-primary">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>