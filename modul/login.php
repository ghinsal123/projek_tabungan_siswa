<?php
    include "service/database.php";
    session_start();

    $login_message = "";

    if(isset($_SESSION["is_login"])) {
        header("location: dashboard.php");
    }

    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hash_password = hash('sha256', $password);

        $sql = "SELECT * FROM users WHERE username='$username' AND password='$hash_password'";
        $result = $db->query($sql);

        if($result->num_rows > 0){
            $data = $result->fetch_assoc();
            $_SESSION["username"] = $data["username"];
            $_SESSION["is_login"] = true;

            header ("location: dashboard.php");

        } else {
            $login_message = "Account not found!";
        }
        $db->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Same styling as the register page for consistency */
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
        .register-link {
            display: block;
            text-align: center;
            margin-top: 15px;
        }
        .register-link a {
            color: #007BFF;
            text-decoration: none;
            font-size: 14px;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Login</h2>
            <?php if ($login_message): ?>
                <p class="error-message"><?= $login_message ?></p>
            <?php endif; ?>
            <form action="login.php" method="POST">
                <div class="form-input">
                    <input type="text" placeholder="Masukkan ussername anda" name="username" required />
                </div>
                <div class="form-input">
                    <input type="password" placeholder="Masukaan password anda" name="password" required />
                </div>
                <div class="register-link">
                <p>Belum punya akun? <a href="register.php">Registrasi disini</a></p>
                </div>
                <div class="form-actions">
                    <a href="../index.php"><button type="button" class="button-cancel">Batal</button></a>
                    <button type="submit" name="login" class="button-submit">Masuk</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
