<?php
session_start();

// DB connection
$servername = "localhost";
$username = "root";
$password = "Sinke008";
$dbname = "login_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check session and fetch DJ details
if (!isset($_SESSION['dj_id'])) {
    // Redirect to login page if not logged in
    header("Location: ../formsdj/Login.php");
    exit();
}

$dj_id = $_SESSION['dj_id'];
$sql = "SELECT 
            username, email, real_name, phone_number, profession, live,
            ponedeljak_klub, utorak_klub, sreda_klub, cetvrtak_klub, petak_klub, subota_klub, nedelja_klub,
            ponedeljak_start, utorak_start, sreda_start, cetvrtak_start, petak_start, subota_start, nedelja_start,
            genre_1, genre_2, genre_3, bio, profile_picture, demo_mp3
        FROM dj 
        WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $dj_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $dj = $result->fetch_assoc();
} else {
    die("DJ profile not found.");
}




$stmt->close();

$isLoggedIn = isset($_SESSION["dj_id"]);

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $real_name = filter_var($_POST['real_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $phone_number = filter_var($_POST['phone_number'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $profession = filter_var($_POST['profession'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $bio = filter_var($_POST['bio'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Sanitize additional columns for the clubs and times
    $ponedeljak_klub = filter_var($_POST['ponedeljak_klub'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $utorak_klub = filter_var($_POST['utorak_klub'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $sreda_klub = filter_var($_POST['sreda_klub'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $cetvrtak_klub = filter_var($_POST['cetvrtak_klub'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $petak_klub = filter_var($_POST['petak_klub'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $subota_klub = filter_var($_POST['subota_klub'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nedelja_klub = filter_var($_POST['nedelja_klub'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $ponedeljak_start = filter_var($_POST['ponedeljak_start'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $utorak_start = filter_var($_POST['utorak_start'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $sreda_start = filter_var($_POST['sreda_start'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $cetvrtak_start = filter_var($_POST['cetvrtak_start'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $petak_start = filter_var($_POST['petak_start'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $subota_start = filter_var($_POST['subota_start'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nedelja_start = filter_var($_POST['nedelja_start'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Sanitize genre inputs
    $genre_1 = filter_var($_POST['genre_1'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $genre_2 = filter_var($_POST['genre_2'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $genre_3 = filter_var($_POST['genre_3'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Construct update SQL query
    $update_sql = "UPDATE dj 
                   SET email = ?, real_name = ?, phone_number = ?, profession = ?, bio = ?,
                       ponedeljak_klub = ?, utorak_klub = ?, sreda_klub = ?, cetvrtak_klub = ?, petak_klub = ?, subota_klub = ?, nedelja_klub = ?,
                       ponedeljak_start = ?, utorak_start = ?, sreda_start = ?, cetvrtak_start = ?, petak_start = ?, subota_start = ?, nedelja_start = ?,
                       genre_1 = ?, genre_2 = ?, genre_3 = ?
                   WHERE id = ?";

    // Bind parameters correctly
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param(
        'ssssssssssssssssssssssi', 
        $email, $real_name, $phone_number, $profession, $bio,
        $ponedeljak_klub, $utorak_klub, $sreda_klub, $cetvrtak_klub, $petak_klub, $subota_klub, $nedelja_klub,
        $ponedeljak_start, $utorak_start, $sreda_start, $cetvrtak_start, $petak_start, $subota_start, $nedelja_start,
        $genre_1, $genre_2, $genre_3, $dj_id
    );

    if ($update_stmt->execute()) {
        header("Location: mikula_info.php?success=1");
        exit();
    } else {
        echo "Error updating profile: " . $update_stmt->error;
    }

    $update_stmt->close();
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Party M - AdminMikula</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/logopartym.png" rel="icon">
  <link href="../assets/img/logopartym.png" rel="apple-touch-icon">


 
  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
 
  <link href="../assets//vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets//vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
 

  

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">
 

 <style>
   body {
    font-family: Arial, sans-serif;
    background-color: #121212;
    color: #ffffff;
    margin: 0;
    padding: 0;
    
}

main{
  width: 80%;
  margin-left: 10%;
}
.upload-section {
    background: #222;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    text-align: center;
}

.upload-section h5 {
    color: #fff;
    margin-bottom: 10px;
}

.profile-image img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #fff;
    margin-bottom: 10px;
}

.demo-audio audio {
    width: 100%;
    margin-top: 10px;
}

.coolinput {
    margin-bottom: 15px;
    text-align: left;
}

.coolinput label {
    display: block;
    font-weight: bold;
    color: #fff;
}

.coolinput input {
    width: 100%;
    padding: 8px;
    border: 1px solid #444;
    background: #333;
    color: #fff;
    border-radius: 5px;
}

button[type="submit"] {
    background: #4b137d;
    color: #fff;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s;
}

button[type="submit"]:hover {
    background: #6a1b9a;
}

h5 {
    color: #fff;
    margin-top: 20px;
}

 </style>

</head>

<body>
<div id="preloader">
  
  </div>
 

  <header id="header" class="fixed-top d-flex align-items-center" style="font-style:italic">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="#">Party M</a></h1>
      

      <nav id="navbar" class="navbar">
        <ul>
          
          <li><a class="nav-link scrollto" href="./mikula.php">Live</a></li>
         
          
          
        
          
         
          
          <li><a class="nav-link active" href="../index.php">Info</a></li>
          <?php if($isLoggedIn): ?>
            <li><a class="getstartedout scrollto" href="../formsdj/logout.php">Logout</a></li>
          <?php else: ?>
            <li><a class="getstarted scrollto" href="../formsdj/Login.php">Login</a></li>
        <?php endif; ?>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center" style="color: white;font-style:italic">
          <h2>Info</h2>
          <ol>
            <li>Party M</li>
            <li><?php echo htmlspecialchars($dj['username'], ENT_QUOTES, 'UTF-8'); ?></li>
            <li>Info</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

 <main id="main">


 <br>
 <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <p style="color: green;">Profile updated successfully!</p>
<?php endif; ?>

<!-- Profile Picture Upload Form -->
<section class="upload-section">
<?php
// Profile Image Display
if ($dj['profile_picture']) {
    echo '<div class="profile-image">
            <img src="../djs/uploads/profile_pictures/' . htmlspecialchars($dj['profile_picture']) . '" alt="Profile Image" />
          </div>';
} else {
    echo '<p>No profile image available.</p>';
}
?>
    <h5>Upload Profile Picture</h5>
    <form action="upload_profile_picture.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="profile_picture">Profile Picture:</label>
            <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</section>

<br>



<!-- Demo MP3 Upload Form -->
<section class="upload-section">
<?php
// Demo Audio Display
if ($dj['demo_mp3']) {
    echo '<div class="demo-audio">
            <audio controls>
                <source src="../djs/uploads/demo_mp3/' . htmlspecialchars($dj['demo_mp3']) . '" type="audio/mp3">
                Your browser does not support the audio element.
            </audio>
          </div>';
} else {
    echo '<p>No demo available.</p>';
}
?>
    <h5>Upload Demo MP3</h5>
    <form action="upload_demo_mp3.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="demo_file">Demo MP3 File:</label>
            <input type="file" id="demo_file" name="demo_file" accept=".mp3">
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</section>




 



 






<form method="POST" class="centered-form">
    <!-- Username -->
    <div class="coolinput">
    <label for="username" class="text">Stage Name:</label>
    <input type="text" id="username" name="username" 
    value="<?= htmlspecialchars($dj['username'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" readonly class="input">
</div>
<div class="coolinput">
    <label for="email" class="text">Email:</label>
    <input type="email" id="email" name="email" 
    value="<?= htmlspecialchars($dj['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" class="input">
</div>
<div class="coolinput">
    <label for="real_name" class="text">Full Name:</label>
    <input type="text" id="real_name" name="real_name" 
    value="<?= htmlspecialchars($dj['real_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" class="input">
</div>
<div class="coolinput">
    <label for="phone_number" class="text">Phone:</label>
    <input type="tel" id="phone_number" name="phone_number" 
    value="<?= htmlspecialchars($dj['phone_number'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" class="input">
</div>
<div class="coolinput">
    <label for="profession" class="text">Profession:</label>
    <input type="text" id="profession" name="profession" 
    value="<?= htmlspecialchars($dj['profession'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" class="input">
</div>
<div class="coolinput">
    <label for="bio" class="text">Bio:</label>
    <input type="text" id="bio" name="bio" 
    value="<?= htmlspecialchars($dj['bio'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" class="input">
</div>
<div class="coolinput">
    <label for="genre_1" class="text">Genre 1:</label>
    <input type="genre" id="genre_1" name="genre_1" 
    value="<?= htmlspecialchars($dj['genre_1'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" class="input">
    <label for="genre_2" class="text">Genre 2:</label>
    <input type="genre" id="genre_2" name="genre_2" 
    value="<?= htmlspecialchars($dj['genre_2'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" class="input">
    <label for="genre_3" class="text">Genre 3:</label>
    <input type="genre" id="genre_3" name="genre_3" 
    value="<?= htmlspecialchars($dj['genre_3'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" class="input">
</div>
        
        
<br><br>
<h5>Ponedeljak</h5>
    <label for="ponedeljak_klub">Klub:</label>
    <input type="text" id="ponedeljak_klub" name="ponedeljak_klub" value="<?= htmlspecialchars($dj['ponedeljak_klub'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
<br>
    <label for="ponedeljak_start">Start Time:</label>
    <input type="time" id="ponedeljak_start" name="ponedeljak_start" value="<?= htmlspecialchars($dj['ponedeljak_start'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">

<br><br>
<h5>Utorak</h5>
    <label for="utorak_klub">Klub:</label>
    <input type="text" id="utorak_klub" name="utorak_klub" value="<?= htmlspecialchars($dj['utorak_klub'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
<br>
    <label for="utorak_start">Start Time:</label>
    <input type="time" id="utorak_start" name="utorak_start" value="<?= htmlspecialchars($dj['utorak_start'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
<br><br>
<h5>Sreda</h5>
    <label for="sreda_klub">Klub:</label>
    <input type="text" id="sreda_klub" name="sreda_klub" value="<?= htmlspecialchars($dj['sreda_klub'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
<br>
    <label for="sreda_start">Start Time:</label>
    <input type="time" id="sreda_start" name="sreda_start" value="<?= htmlspecialchars($dj['sreda_start'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
<br><br>
<h5>Cetvrtak</h5>
    <label for="cetvrtak_klub">Klub:</label>
    <input type="text" id="cetvrtak_klub" name="cetvrtak_klub" value="<?= htmlspecialchars($dj['cetvrtak_klub'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
    <br>
    <label for="cetvrtak_start">Start Time:</label>
    <input type="time" id="cetvrtak_start" name="cetvrtak_start" value="<?= htmlspecialchars($dj['cetvrtak_start'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
<br><br>
<h5>Petak</h5>
    <label for="petak_klub">Klub:</label>
    <input type="text" id="petak_klub" name="petak_klub" value="<?= htmlspecialchars($dj['petak_klub'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
    <br>
    <label for="petak_start">Start Time:</label>
    <input type="time" id="petak_start" name="petak_start" value="<?= htmlspecialchars($dj['petak_start'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
<br><br>
<h5>Subota</h5>
    <label for="subota_klub">Klub:</label>
    <input type="text" id="subota_klub" name="subota_klub" value="<?= htmlspecialchars($dj['subota_klub'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
<br>
    <label for="subota_start">Start Time:</label>
    <input type="time" id="subota_start" name="subota_start" value="<?= htmlspecialchars($dj['subota_start'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
<br><br>
<h5>Nedelja</h5>
    <label for="nedelja_klub">Klub:</label>
    <input type="text" id="nedelja_klub" name="nedelja_klub" value="<?= htmlspecialchars($dj['nedelja_klub'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
<br>
    <label for="nedelja_start">Start Time:</label>
    <input type="time" id="nedelja_start" name="nedelja_start" value="<?= htmlspecialchars($dj['nedelja_start'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
<br><br>







<br>

<button type="submit">Update Profile</button>
</form>





</main>




<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
  




  <!-- ======= Footer ======= -->
  <footer id="footer" style="font-style:italic">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6">
            <div class="footer-info">
              <h3>Party M <img src="../assets/img/logopartym.png" alt="" style="width:70px; height:70px;"></h3>
              
              <p>
                <strong>Email:</strong> info@partym.rs<br>
              </p>
              <div class="social-links mt-3">
                <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="google-plus"><i class="bi bi-skype"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-3 offset-lg-6 col-md-6 footer-links">
            <h4>Nasi Servisi</h4>
            <ul>
              
              <li><i class="bi bi-arrow-right-short"></i> <a href="../restoranikafici.php">Restorani/Kafici</a></li>
              
              
            </ul>
            <br>
            <h4>Partneri:</h4>
            <ul>
              
              <li><i class="bi bi-arrow-right-short"></i> <a href="#">Točionica</a></li>
              
              
            </ul>
            
          </div>

          

        </div>
      </div>
    </div>
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>Party M</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
       
        Designed by Zaun
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  

  <script>
var loader = document.getElementById("preloader");

window.addEventListener("load", function() {
  // Fade out the loader
  loader.style.opacity = "0";
  
  // Wait for the transition to complete before hiding it
  setTimeout(function() {
    loader.style.display = "none";
  }, 500); // Match this time to your CSS transition duration
});
</script>




  <!-- Vendor JS Files -->
  <script src="../assets/"></script>
  <script src="../assets//vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets//vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets//vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../assets//vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../assets//vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets//js/main.js"></script>


</body>

</html>
