<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM dj
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $dj = $result->fetch_assoc();
    
    if ($dj) {
        
        if (password_verify($_POST["password"], $dj["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["dj_id"] = $dj["id"];
            
            header("Location: ../djadmin/mikula.php");
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

    <title>Party M - MLogin</title>

    <link rel="stylesheet" href="../assets/css/LoginMenadzer.css">

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
    background:rgb(0, 0, 0);
}

.login-container {
    background:rgb(45, 154, 129);
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
    border: 1px rgb(240, 240, 240);
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
    color:rgb(255, 255, 255);
}

.actions button {
    width: 100%;
    padding: 10px;
    background:rgb(0, 0, 0);
    border: none;
    border-radius: 5px;
    color: white;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s ease;
}

.actions button:hover {
    background:rgb(46, 134, 83);
}

.links {
    margin-top: 20px;
}

.links a {
    color:rgb(50, 115, 71);
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
        <img src="../assets/img/logo3.png" alt="logo" width="100">
        
        <h2>DJ Login</h2>
        
        <form id="loginForm" method="POST">
            <div class="input-group">
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" required>
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <input type="password" id="password" name="password" required>
                <label for="password">Password</label>
            </div>

            <div style="color: red; margin:10px;">
                <?php if ($is_invalid): ?>
                <em>Try Again</em>
                <?php endif; ?></div>


            <div class="actions">
                <button type="submit">Log In</button>
            </div>
            
        </form>
    </div>

</body>

</html>