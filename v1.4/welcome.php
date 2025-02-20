<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: home.php");
    exit;
}

switch ($_SESSION['role']) {
    case 'admin':
        header("Location: admin_dashboard.php");
        break;
    case 'judge':
        header("Location: judge_dashboard.php");
        break;
    case 'lawyer':
        header("Location: lawyer_dashboard.php");
        break;
    case 'litigant':
        header("Location: litigant_dashboard.php");
        break;
    default:
        header("Location: home.php");
}

exit;
?>
<a href="logout.php">Logout</a>