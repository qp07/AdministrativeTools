<?php
$conn = new mysqli("localhost", "root", "", "auth_system");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim(htmlspecialchars($_POST['username']));
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role']; // Removed htmlspecialchars since this is from a dropdown

    // Validate role
    $allowed_roles = ['litigant', 'lawyer', 'judge'];
    if (!in_array($role, $allowed_roles)) {
        die("Invalid role selected.");
    }

    // Check if the username already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Username already exists.";
    } else {
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $role);
        
        if ($stmt->execute()) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .registration-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .registration-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            transform: translateY(0);
            transition: transform 0.3s ease;
        }

        .registration-card:hover {
            transform: translateY(-5px);
        }

        .registration-title {
            text-align: center;
            color: #2d3748;
            margin-bottom: 2rem;
            font-size: 2rem;
            position: relative;
        }

        .registration-title::after {
            content: '';
            display: block;
            width: 50px;
            height: 3px;
            background: #667eea;
            margin: 0.5rem auto;
            border-radius: 2px;
        }

        .input-icon {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
        }

        .role-selector {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .role-card {
            background: #f7fafc;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }

        .role-card:hover {
            border-color: #667eea;
            background: #fff;
        }

        .role-card.active {
            border-color: #667eea;
            background: #ebf4ff;
        }

        .role-card input[type="radio"] {
            display: none;
        }

        .register-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .register-btn:hover {
            transform: scale(1.02);
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #4a5568;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="registration-container">
        <div class="registration-card">
            <h1 class="registration-title">Create Account</h1>
            
            <?php if(isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if(isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="input-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" 
                           name="username" 
                           class="form-control" 
                           placeholder="Username"
                           required
                           style="padding-left: 40px;">
                </div>

                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" 
                           name="password" 
                           class="form-control" 
                           placeholder="Password"
                           required
                           style="padding-left: 40px;">
                </div>

                <div class="role-selector">
                    <label class="role-card">
                        <input type="radio" name="role" value="litigant" required>
                        <div class="role-content">
                            <i class="fas fa-user-friends fa-2x"></i>
                            <h3>Litigant</h3>
                        </div>
                    </label>

                    <label class="role-card">
                        <input type="radio" name="role" value="lawyer">
                        <div class="role-content">
                            <i class="fas fa-balance-scale fa-2x"></i>
                            <h3>Lawyer</h3>
                        </div>
                    </label>

                    <label class="role-card">
                        <input type="radio" name="role" value="judge">
                        <div class="role-content">
                            <i class="fas fa-gavel fa-2x"></i>
                            <h3>Judge</h3>
                        </div>
                    </label>
                </div>

                <button type="submit" class="register-btn">Register Now</button>
            </form>

            <div class="login-link">
                Already have an account? <a href="login.php">Sign In</a>
            </div>
        </div>
    </div>

    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/your-kit-code.js"></script>
    <script>
        // Add active class to selected role card
        document.querySelectorAll('.role-card input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', () => {
                document.querySelectorAll('.role-card').forEach(card => {
                    card.classList.remove('active');
                });
                if(radio.checked) {
                    radio.closest('.role-card').classList.add('active');
                }
            });
        });
    </script>
</body>
</html>