<?php
function authorize($required_role) {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $required_role) {
        header("Location: unauthorized.php");
        exit;
    }
}
?>