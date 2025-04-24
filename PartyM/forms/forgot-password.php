<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link href="../assets/img/logopartym.png" rel="icon">
    <link href="../assets/img/logopartym.png" rel="apple-touch-icon">
    <title>Forgot Password</title>
</head>
<body>

<h1>Zaboravili ste lozinku?</h1><br>

<form method="post" action="./send-password-reset.php">

        <label for="email">Unesite Vaš email:</label>
        <input type="email" name="email" id="email">

        <button>Send</button>

    </form>
    <p style="font-style:italic">Na email Vam šaljemo link na kom možete da promenite svoju lozinku.</p>
    
</body>
</html>