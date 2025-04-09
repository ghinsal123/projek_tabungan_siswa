<?php
    include "service/database.php";
    $register_message = "";

    if(isset($_POST['register'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Check if passwords match
        if ($password !== $confirm_password) {
            $register_message = "Passwords do not match.";
        } else {
            $hash_password = hash('sha256', $password);

            // Check if username already exists
            $sql = "SELECT * FROM users WHERE username='$username'";
            $result = $db->query($sql);

            if($result->num_rows > 0) {
                $register_message = "Username already taken.";
            } else {
                // Insert new user into database
                $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$hash_password', 'user')";
                if ($db->query($sql) === TRUE) {
                    $register_message = "Registration successful! Please login.";
                    header("Location: login.php"); // Redirect to login after successful registration
                    exit();
                } else {
                    $register_message = "Error: " . $db->error;
                }
            }
        }
        $db->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        /* Reusing the same styles from your login page for consistency */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-box {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .form-input {
            margin-bottom: 15px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        .button-submit {
            background-color: #4CAF50;
            color: white;
        }
        .button-submit:hover {
            background-color: #45a049;
        }
        .button-cancel {
            background-color: #f44336;
            color: white;
            margin-right: 10px;
        }
        .button-cancel:hover {
            background-color: #e53935;
        }
        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .error-message {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-bottom: 15px;
        }
        .login-link {
            display: block;
            text-align: center;
            margin-top: 15px;
        }
        .login-link a {
            color: #007BFF;
            text-decoration: none;
            font-size: 14px;
        }
        .login-link a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Register</h2>
            <?php if ($register_message): ?>
                <p class="error-message"><?= $register_message ?></p>
            <?php endif; ?>
            <form action="register.php" method="POST">
                <div class="form-input">
                    <input type="text" placeholder="Masukkan ussername anda" name="username" required />
                </div>
                <div class="form-input">
                    <input type="password" placeholder="Masukkan password anda" name="password" required />
                </div>
                <div class="form-input">
                    <input type="password" placeholder="Konfirmasi password anda" name="confirm_password" required />
                </div>
                <div class="login-link">
                <p>Sudah punya akun? <a href="login.php">Masuk disini</a></p>
                </div>
                <div class="form-actions">
                    <a href="../index.php"><button type="button" class="button-cancel">Batal</button></a>
                    <button type="submit" name="register" class="button-submit">Daftar</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
