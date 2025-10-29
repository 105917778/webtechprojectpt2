<?php
include 'settings.php';

$login_error = '';
$registration_success = isset($_GET['registration']) && $_GET['registration'] == 'success';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $identifier = trim($_POST['username_email']); // Can be username or email
    $password = $_POST['password'];

    $sql = "SELECT user_id, username, password_hash FROM users 
            WHERE username = ? OR email = ?";
    
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$identifier, $identifier])) {
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];

            header('Location: index.html'); 
            exit();
            
        } else {
            $login_error = "Invalid username/email or password.";
        }
    } else {
         $login_error = "An unexpected error occurred during login.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Login</title>
    <link href="resources/styles.css" rel="stylesheet">
    <style>
        .login-container {
            width: 300px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            text-align: center;
        }
        input[type="text"], input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #004690;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        .message {
            margin-bottom: 15px;
            padding: 8px;
            border-radius: 4px;
        }
        .error-message {
            color: #b00;
            background-color: #fdd;
        }
        .success-message {
            color: #060;
            background-color: #dfd;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login to LifeReady</h2>
        
        <?php if ($registration_success): ?>
            <p class="message success-message">Registration successful! You may now log in.</p>
        <?php endif; ?>
        
        <?php if ($login_error): ?>
            <p class="message error-message"><?php echo htmlspecialchars($login_error); ?></p>
        <?php endif; ?>
        
        <form method="POST" action="login.php"> 
            
            <label for="username_email">Username or Email:</label>
            <input type="text" id="username_email" name="username_email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Log In</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>