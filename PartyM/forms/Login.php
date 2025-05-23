﻿<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            $redirect_url = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : '../index.php';

            
            
            header("Location: " . $redirect_url);
            
            exit;
        }
    }
    
    $is_invalid = true;
}
?>



<!doctype html>

<html lang="en">

<head>

<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Brygada+1918:ital,wght@0,400..700;1,400..700&family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="../assets/img/logopartym.png" rel="icon">
    <link href="../assets/img/logopartym.png" rel="apple-touch-icon">

    <title>Party M Login</title>


    <style>
        * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: 'Arial', sans-serif;
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background: white;
}

.login-container {
    background: #4b137d;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    width: 300px;
    color: white;
    text-align: center;
}

.login-container h2 {
    margin-bottom: 20px;
    color: #ffffff;
}

.input-group {
    position: relative;
    margin-bottom: 30px;
}

.input-group input {
    width: 100%;
    padding: 10px;
    background: none;
    border: 1px solid #4f5b7a;
    border-radius: 5px;
    color: white;
    outline: none;
}

.input-group label {
    position: absolute;
    top: 10px;
    left: 10px;
    color: #808db1;
    pointer-events: none;
    transition: 0.2s ease all;
}

.input-group input:focus ~ label,
.input-group input:not(:placeholder-shown) ~ label {
    top: -15px;
    left: 10px;
    font-size: 12px;
    color: #00aaff;
}

.actions button {
    width: 100%;
    padding: 10px;
    background: white;
    border: none;
    border-radius: 5px;
    color: #4b137d;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s ease;
}

.actions button:hover {
    background: #2f0752;
    color: white;
}

.links {
    margin-top: 20px;
}

.links a {
    color: white;
    text-decoration: none;
    font-size: 14px;
    display: block;
    margin: 5px 0;
}

.links a:hover {
    text-decoration: underline;
}

    </style>

</head>

<body>
    <!-- partial:index.partial.html -->

   


    <div class="login-container">
        <img src="../assets/img/logo3.png" alt="logo" width="100" style="margin-bottom: 25px">
        
        
        <form id="loginForm" method="POST">
            <div class="input-group">
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" required>
                <label for="email" style="color:white">Email</label>
            </div>
            <div class="input-group">
                <input type="password" id="password" name="password" required>
                <label for="password" style="color:white">Password</label>
            </div>

            <div style="color: red; margin:10px;">
                <?php if ($is_invalid): ?>
                <em>Try Again</em>
                <?php endif; ?></div>


            <div class="actions">
                <button type="submit">Log In</button>
            </div>
            
        </form>

        <div class="links">
            <a href="./forgot-password.php">Forgot Password?</a>
            <a href="./SignUp.html">Create Account</a>
        </div>
    </div>

</body>

</html>