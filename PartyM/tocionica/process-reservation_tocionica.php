<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: tocionica.php?error=133"); 
    exit(); 
}

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    header("Location: tocionica.php?error=322");
        exit();
  }

  if (!empty($_POST['honeypott'])) {
    header("Location: tocionica.php?error=411");
        exit();
}


include 'dbconnect.php';

// Variables for icon, title, message, and colors
$icon = '✓';
$title = 'Uspešno';
$message = "Uspešno ste poslali zahtev za rezervaciju. Hvala Vam što koristite Party M.";
$iconColor = '#88B04B'; // Green
$titleColor = '#88B04B'; // Green
$linkMessage = "<p>Na linku ispod možete pratiti status Vaše rezervacije.</p>";

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Sanitize and validate input data
    $user_id = $_SESSION['user_id'];
    $ime = htmlspecialchars(trim($_POST['ime']), ENT_QUOTES, 'UTF-8');
    $vrstarez = htmlspecialchars(trim($_POST['vrstarez']), ENT_QUOTES, 'UTF-8');
    $brojtelefona = htmlspecialchars(trim($_POST['brojtelefona']), ENT_QUOTES, 'UTF-8');
    $brojljudi = (int) $_POST['brojljudi']; // Ensure it's an integer
    $zadatum = htmlspecialchars(trim($_POST['zadatum']), ENT_QUOTES, 'UTF-8');
    $vremedolaska = htmlspecialchars(trim($_POST['vremedolaska']), ENT_QUOTES, 'UTF-8');
    $mestosedenja = htmlspecialchars(trim($_POST['mestosedenja']), ENT_QUOTES, 'UTF-8');
    $sedenje = htmlspecialchars(trim($_POST['sedenje']), ENT_QUOTES, 'UTF-8');
    $email = filter_var($_POST['user_email'], FILTER_SANITIZE_EMAIL); // Sanitize email

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO tocionica (id, ime, brojtelefona, brojstola, vrstarez, brojljudi, reservationstatus, zadatum, vremedolaska, vremerez, mesto, mestosedenja, sedenje, email, notification_sent, kasnjenje) VALUES (?, ?, ?, '#', ?, ?, 'pending', ?, ?, NOW(), 'tocionica', ?, ?, ?, '0', NULL)");
    $stmt->bind_param("isssisssss", $user_id, $ime, $brojtelefona, $vrstarez, $brojljudi, $zadatum, $vremedolaska, $mestosedenja, $sedenje, $email);

    // Execute the prepared statement
    $stmt->execute();

    // Close connections
    $stmt->close();
    $conn->close();

    // Append the link message to the main message
    $message .= $linkMessage;

} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1062) {
        $icon = '✗';
        $title = 'Neuspešno';
        $message = "Već imate rezervaciju za ovaj lokal.";
        $message .= "<p>Proverite svoju rezervaciju na profilu.</p>";
        $iconColor = '#FF6347'; // Red
        $titleColor = '#FF6347'; // Red
    } else {
        $icon = '✗';
        $title = 'Neuspešno';
        $message = "Došlo je do greške: " . $e->getMessage();
        $iconColor = '#FF6347'; // Red
        $titleColor = '#FF6347'; // Red
    }
} catch (Exception $e) {
    $icon = '✗';
    $title = 'Neuspešno';
    $message = "Došlo je do greške: " . $e->getMessage();
    $iconColor = '#FF6347'; // Red
    $titleColor = '#FF6347'; // Red
}
?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
    <style>
        body {
            text-align: center;
            padding: 40px 0;
            background: #EBF0F5;
        }
        h1 {
            font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
            font-weight: 900;
            font-size: 40px;
            margin-bottom: 10px;
        }
        p {
            color: #404F5E;
            font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
            font-size: 20px;
            margin: 0;
        }
        i {
            font-size: 100px;
            line-height: 200px;
            margin-left: -15px;
        }
        .card {
            background: white;
            padding: 60px;
            border-radius: 4px;
            box-shadow: 0 2px 3px #C8D0D8;
            display: inline-block;
            margin: 0 auto;
        }
        .button {
  padding: 1em 2em;
  border: none;
  border-radius: 5px;
  font-weight: bold;
  letter-spacing: 3px;
  text-transform: uppercase;
  cursor: pointer;
  color: #2c9caf;
  transition: all 800ms;
  font-size: 15px;
  position: relative;
  overflow: hidden;
  outline: 2px solid #2c9caf;
}

button:hover {
  color: #ffffff;
  transform: scale(1.1);
  outline: 2px solid #70bdca;
  box-shadow: 4px 5px 17px -4px #268391;
}

button::before {
  content: "";
  position: absolute;
  left: -50px;
  top: 0;
  width: 0;
  height: 100%;
  background-color: #2c9caf;
  transform: skewX(45deg);
  z-index: -1;
  transition: width 800ms;
}

button:hover::before {
  width: 250%;
}
    </style>
</head>
<body>
    <div class="card">
        <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
            <i style="color: <?php echo $iconColor; ?>;"><?php echo $icon; ?></i>
        </div>
        <h1 style="color: <?php echo $titleColor; ?>;"><?php echo $title; ?></h1>
        <p><?php echo $message; ?><br/><a href="../profil.php"><button class="button">Profil</button></a></p>
    </div>
</body>
</html>
