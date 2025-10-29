<?php

// 1. Include the centralized configuration and database connection
include 'settings.php';

$register_error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 2. Collect and Sanitize Input
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // 3. Validation
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $register_error = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $register_error = "Passwords do not match.";
    } elseif (strlen($password) < 8) {
        $register_error = "Password must be at least 8 characters long.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $register_error = "Please enter a valid email address.";
    } else {
        // 4. Check for existing username/email
        $sql_check = "SELECT user_id FROM users WHERE username = ? OR email = ?";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->execute([$username, $email]);

        if ($stmt_check->fetch()) {
            $register_error = "Username or Email is already taken. Please choose another.";
        } else {
            // 5. Secure Hashing and Insertion
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $sql_insert = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)";
            $stmt_insert = $pdo->prepare($sql_insert);
            
            if ($stmt_insert->execute([$username, $email, $password_hash])) {
                header('Location: login.php?registration=success');
                exit();
            } else {
                $register_error = "Registration failed due to a database error.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
    <link href="resources/styles.css" rel="stylesheet"> 
    <style>
        .register-container {
            width: 350px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            text-align: center;
        }
        input[type="text"], input[type="email"], input[type="password"] {
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
        .error-message {
            color: red;
            margin-bottom: 15px;
            border: 1px solid #fdd;
            background-color: #ffe;
            padding: 5px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Register for LifeReady</h2>
        
        <?php if ($register_error): ?>
            <p class="error-message"><?php echo htmlspecialchars($register_error); ?></p>
        <?php endif; ?>

        <form method="POST" action="register.php"> 
            
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required 
                   value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required
                   value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">

            <label for="password">Password (min 8 chars):</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>