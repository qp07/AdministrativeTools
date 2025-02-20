<?php
session_start();
$conn = new mysqli("localhost", "root", "", "auth_system");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo "Error: User ID is not set. Current session variables: ";
        print_r($_SESSION);
        exit; // Exit if the user ID is not set
    }

    $user_id = $_SESSION['user_id']; // Ensure user ID is stored in the session
    $content = trim(htmlspecialchars($_POST['content']));
    $issue_type = $_POST['issue_type']; // Retrieve issue type

    // Handle the image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($_FILES['image']['tmp_name']);
        if (strpos($mime, 'image/') === 0) {
            $image = file_get_contents($_FILES['image']['tmp_name']);
        } else {
            die("Invalid file type. Only images are allowed.");
        }
    } else {
        die("Image is required.");
    }

    $stmt = $conn->prepare("INSERT INTO issues (User_ID, Content, Date, Issue_state, Issue_type, image) VALUES (?, ?, NOW(), 'pending', ?, ?)");
    $stmt->bind_param("isss", $user_id, $content, $issue_type, $image);
    
    if ($stmt->execute()) {
        echo "Issue submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
<a href="welcome.php">Go Back</a>