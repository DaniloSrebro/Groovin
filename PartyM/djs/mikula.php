<?php
// Connect to rezervacije database
$rezervacije_servername = "localhost";
$rezervacije_username = "root";
$rezervacije_password = "Sinke008";
$rezervacije_dbname = "rezervacije";

$conn_rezervacije = new mysqli($rezervacije_servername, $rezervacije_username, $rezervacije_password, $rezervacije_dbname);

if ($conn_rezervacije->connect_error) {
    die("Connection to rezervacije database failed: " . $conn_rezervacije->connect_error);
}

// Query to get the sum of brojljudi
$sql_total_brojljudi = "SELECT SUM(brojljudi) AS total FROM tocionica WHERE reservationstatus='approved'";
$result_total_brojljudi = $conn_rezervacije->query($sql_total_brojljudi);

$total_brojljudi = 0;
if ($result_total_brojljudi->num_rows > 0) {
    $row_total_brojljudi = $result_total_brojljudi->fetch_assoc();
    $total_brojljudi = $row_total_brojljudi["total"];
}

$conn_rezervacije->close();

// Connect to djlikes database
$djlikes_servername = "localhost";
$djlikes_username = "root";
$djlikes_password = "Sinke008";
$djlikes_dbname = "djlikes";

$conn_djlikes = new mysqli($djlikes_servername, $djlikes_username, $djlikes_password, $djlikes_dbname);

if ($conn_djlikes->connect_error) {
    die("Connection to djlikes database failed: " . $conn_djlikes->connect_error);
}

session_start();

$_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];

$liked = false;
if (isset($_SESSION["user_id"])) {
    // Check if user has liked the DJ
    $user_id = $_SESSION["user_id"];
    $sql_check_like = "SELECT * FROM mikula WHERE user_id = ?";
    $stmt_check_like = $conn_djlikes->prepare($sql_check_like);
    $stmt_check_like->bind_param("i", $user_id);
    $stmt_check_like->execute();
    $result_check_like = $stmt_check_like->get_result();
    
    if ($result_check_like->num_rows > 0) {
        $liked = true;
    }
}

$isLoggedIn = isset($_SESSION["user_id"]);

$conn_djlikes->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Party M DJ Profile</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <meta name="viewport" content="width=device-width, initial-scale=1">



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">

  <link rel="stylesheet" href="../assets/css/events.css">


  <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

  <style>
    body{
        background: -webkit-linear-gradient(left, #800080, #000000);
}

.emp-profile{
    padding: 3%;
    margin-top: 3%;
    margin-bottom: 3%;
    border-radius: 0.5rem;
    background: #fff;
}
.container1{
    margin-left: 13%;
    margin-right: 13%;
    margin-top: 2%;
    
}
@media only screen and (max-width: 900px) {
   
    .container1{
    margin-left: 5%;
    margin-right: 5%;
    margin-top: 5%;
}
    
}
.profile-img{
    text-align: center;
}
.profile-img img{
    width: 70%;
    height: 100%;
}
.profile-img .file {
    position: relative;
    overflow: hidden;
    margin-top: -20%;
    width: 70%;
    border: none;
    border-radius: 0;
    font-size: 15px;
    background: #212529b8;
}
.profile-img .file input {
    position: absolute;
    opacity: 0;
    right: 0;
    top: 0;
}
.profile-head h5{
    color: black;
}
.profile-head h6{
    color: black;
}
.profile-edit-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            font-size: 16px;
            background: -webkit-linear-gradient(left, #800080, #000000);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .profile-edit-btn i {
            margin-right: 8px;
        }

        .profile-edit-btn:hover {
            background-color: #2273e0;
        }
        .profile-edit-btn.playing {
            
            box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px inset, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px inset;
        }



        .profile-edit-btn-mali {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 15px;
            
            padding: 5px 10px;
            font-size: 14px;
            background: -webkit-linear-gradient(left, #800080, #000000);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .profile-edit-btn-mali i {
            margin-right: 5px;
        }

        .profile-edit-btn-mali:hover {
            background-color: #2273e0;
        }
        .profile-edit-btn-mali.playing {
            
            box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px inset, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px inset;
        }
 
        



.proile-rating{
    font-size: 12px;
    color: black;
    margin-top: 5%;
}
.proile-rating span{
    color: black;
    font-size: 15px;
    font-weight: 600;
}
.profile-head .nav-tabs{
    
    margin-bottom:5%;
}
.profile-head .nav-tabs .nav-link{
    color: grey;
    font-weight:600;
    border: none;
}
.profile-head .nav-tabs .nav-link.active{
    color: black;
    
    border: none;
    border-bottom:2px solid grey;
}

@media only screen and (max-width: 900px) {
   
    .profile-head h5{
    margin-top: 20px;
}
}
.profile-work{
    padding: 14%;
    padding-top: 2%;
    
    margin-top: 0%;
}
.profile-work p{
    font-size: 12px;
    color: #818182;
    font-weight: 600;
    margin-top: 10%;
}
.profile-work a{
    text-decoration: none;
    color: #495057;
    font-weight: 600;
    font-size: 14px;
}
.profile-work ul{
    list-style: none;
}
.profile-tab label{
    font-weight: 600;
}
.profile-tab p{
    font-weight: 600;
    color: black;
}
.heart-container {
  --heart-color: rgb(189, 91, 255);
  position: relative;
  width: 50px;
  height: 50px;
  transition: .3s;
}

.heart-container .checkbox {
  position: absolute;
  width: 70%;
  height: 70%;
  opacity: 0;
  z-index: 20;
  cursor: pointer;
}

.heart-container .svg-container {
  width: 70%;
  height: 70%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.heart-container .svg-outline,
        .heart-container .svg-filled {
  fill: var(--heart-color);
  position: absolute;
}

.heart-container .svg-filled {
  animation: keyframes-svg-filled 1s;
  display: none;
}

.heart-container .svg-celebrate {
  position: absolute;
  animation: keyframes-svg-celebrate .5s;
  animation-fill-mode: forwards;
  display: none;
  stroke: var(--heart-color);
  fill: var(--heart-color);
  stroke-width: 2px;
}

.heart-container .checkbox:checked~.svg-container .svg-filled {
  display: block
}

.heart-container .checkbox:checked~.svg-container .svg-celebrate {
  display: block
}

@keyframes keyframes-svg-filled {
  0% {
    transform: scale(0);
  }

  25% {
    transform: scale(1.2);
  }

  50% {
    transform: scale(1);
    filter: brightness(1.5);
  }
}

@keyframes keyframes-svg-celebrate {
  0% {
    transform: scale(0);
  }

  50% {
    opacity: 1;
    filter: brightness(1.5);
  }

  100% {
    transform: scale(1.4);
    opacity: 0;
    display: none;
  }
}

.recenica {
    font-style: italic;
    background-color: yellow;
    padding: 6px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
}




.profile-content {
    
    display: block;
    opacity: 1;
    transition: opacity 0.5s ease, max-height 0.5s ease;
    max-height: 1000px; /* large enough to fit the content */
    overflow: hidden;
}

/* Media query for small screens */



.galerija {
    margin-bottom: 15px; /* Add spacing between images */
    text-align: center;  /* Center images within their columns */
}

.galerija {
        position: relative; /* Make the parent container relative */
    }

    .play-button {
        position: absolute; /* Position the play button */
        top: 50%; /* Center vertically */
        left: 50%; /* Center horizontally */
        transform: translate(-50%, -50%); /* Offset to center */
        cursor: pointer; /* Change cursor to pointer */
        z-index: 10; /* Ensure the button is on top */
        font-size: 2rem; /* Set the size of the icon */
        color: white; /* Color of the icon */
        opacity: 0.9; /* Slight transparency */
        transition: opacity 0.3s; /* Smooth transition for hover effect */
    }

    .play-button:hover {
        opacity: 1; /* Fully opaque on hover */
    }

.galerija img {
    max-width: 100%;    /* Ensure images are responsive */
    height: auto;       /* Maintain aspect ratio */
    transition: transform 0.3s ease-in-out; /* Smooth hover effect */
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); /* Add subtle shadow */
}

.galerija img:hover {
    transform: scale(1.05); /* Slight zoom on hover */
}

.profile-edit-btn-mali{
    display: none;
}

.maliekran{
    display: none;
}

@media (max-width: 768px) {
    .galerija {
        margin-bottom: 10px; /* Adjust margins for smaller screens */
    }
    .play-button {

        font-size: 3rem; 
    }
    .profile-edit-btn{
        display: none;
    }
    .profile-edit-btn-mali{
        display: block;
    }
    .profile-work{
        display: none;
    }
    .maliekran{
    display: block;
}
}

.malodugme{
    display: flex;
    justify-content: space-between;
}


.social-icon i {
    font-size: 24px;
    margin: 5px;
  }

  .social-icon {
    text-decoration: none;
  }



  /* .asdasd{
    NOVI APDEJT;
  } */

  .review {
    display: flex;
    align-items: flex-start;
    margin-bottom: 15px;
    padding: 10px;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.review-img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 15px;
    object-fit: cover;
}

.review-content {
    max-width: 600px;
}

.review-content h4 {
    margin: 0;
    font-size: 1.1em;
    font-weight: bold;
    color: #333;
}

.review-content p {
    margin: 5px 0 0;
    font-size: 0.95em;
    color: #555;
}

.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: #fff;
    margin: 15% auto;
    padding: 20px;
    border-radius: 8px;
    width: 80%;
    max-width: 400px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.close-btn {
    float: right;
    font-size: 20px;
    font-weight: bold;
    color: #aaa;
    cursor: pointer;
}

.close-btn:hover {
    color: #000;
}

h2 {
    font-size: 1.5rem;
    color: #333;
}

.rating-choice label {
    display: inline-block;
    margin: 10px 15px;
    cursor: pointer;
}

.rating-choice input {
    margin-right: 5px;
}

.form-group textarea {
    width: 100%;
    height: 100px;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 10px;
    font-size: 14px;
}

.btn-submit {
    display: inline-block;
    padding: 10px 20px;
    background-color: #4b137d; /* Main color */
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 10px;
    font-size: 14px;
}

.btn-submit:hover {
    background-color: #360d59;
}

.review-date {
    font-size: 0.9em;
    color: #888;
    margin-top: 5px;
}
.modal {
    display: none; /* Hidden by default */
    position: fixed;
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.search-result-item {
    padding: 8px;
    margin-bottom: 10px;
    background-color: #f1f1f1;
    border: 1px solid #ddd;
    cursor: pointer;
}


/* CSS */
.button-8 {
  background-color: #e1ecf4;
  border-radius: 3px;
  border: 1px solid #7aa7c7;
  box-shadow: rgba(255, 255, 255, .7) 0 1px 0 0 inset;
  box-sizing: border-box;
  color: #39739d;
  cursor: pointer;
  display: inline-block;
  font-family: -apple-system,system-ui,"Segoe UI","Liberation Sans",sans-serif;
  font-size: 13px;
  font-weight: 400;
  line-height: 1.15385;
  margin: 0;
  outline: none;
  padding: 8px .8em;
  position: relative;
  text-align: center;
  text-decoration: none;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  vertical-align: baseline;
  white-space: nowrap;
}

.button-8:hover,
.button-8:focus {
  background-color: #b3d3ea;
  color: #2c5777;
}

.button-8:focus {
  box-shadow: 0 0 0 4px rgba(0, 149, 255, .15);
}

.button-8:active {
  background-color: #a0c7e4;
  box-shadow: none;
  color: #2c5777;
}


.live-status {
    display: flex;
    align-items: center;
}

.live-indicator {
    background-color: green;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin-left: 10px;
}

.live-text {
    margin-left: 5px;
    color: green;
}


  </style>

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center" style="font-style:italic;">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="index.html">Party M</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar">
        <ul>
          
          <li><a class="nav-link scrollto" href="../index.php">Početna</a></li>
         
          
          
        
          
         
          <li class="dropdown"><a href="#"><span>Lokali</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              
              
              <li><a href="../restoranikafici.php">Restorani i Kafici</a></li>
              
              
            </ul>
            <li class="dropdown"><a href="#"><span>HotCue</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              
              
              <li><a href="../dj.php">DJ</a></li>
              <li><a class="nav-link" href="../events.php">Events</a></li>
              
            </ul>
            <li><a class="nav-link" href="../profil.php">Profil</a></li>
            
          </li>
          <li><a class="nav-link scrollto" href="./index.php#contact">Kontakt</a></li>
          <?php if($isLoggedIn): ?>
            <li><a class="getstartedout scrollto" href="../forms/logout.php">Logout</a></li>
          <?php else: ?>
            <li><a class="getstarted scrollto" href="../forms/Login.php">Login</a></li>
        <?php endif; ?>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs" style="font-style:italic">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2 style="color:white">Dj - Profile</h2>
          <ol>
            <li style="color:white"><a href="../index.php">Party M</a></li>
            <li style="color:white"><a href="../dj.php">DJ</a></li>
            <li style="color:white">Profil</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->



  

  </main><!-- End #main -->
  

  


<div class="container1 emp-profile">
            
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img">
                            <img src="../assets/img/djj.jpg" alt=""/>
                            <div class="file btn btn-lg btn-primary" style="display:none">
                                Change Photo
                                <input type="file" name="file"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-head">
                            <div class="malodugme">
                                    <h5>
                                        Mikula  </h5> <div class="col-md-2">
                                        <button type="button" class="profile-edit-btn-mali" id="playDemoBtnMali">
                                            <i class="fas fa-play"></i> <span>Play Demo</span>
                                            
                                        </button>
                                        </div>   </div>
                                         <div title="Like" class="heart-container">
            <input id="Give-It-An-Id" class="checkbox" type="checkbox" <?php echo ($liked ? 'checked' : ''); ?>>
            <div class="svg-container">
                <svg xmlns="http://www.w3.org/2000/svg" class="svg-outline" viewBox="0 0 24 24">
                    <path d="M17.5,1.917a6.4,6.4,0,0,0-5.5,3.3,6.4,6.4,0,0,0-5.5-3.3A6.8,6.8,0,0,0,0,8.967c0,4.547,4.786,9.513,8.8,12.88a4.974,4.974,0,0,0,6.4,0C19.214,18.48,24,13.514,24,8.967A6.8,6.8,0,0,0,17.5,1.917Zm-3.585,18.4a2.973,2.973,0,0,1-3.83,0C4.947,16.006,2,11.87,2,8.967a4.8,4.8,0,0,1,4.5-5.05A4.8,4.8,0,0,1,11,8.967a1,1,0,0,0,2,0,4.8,4.8,0,0,1,4.5-5.05A4.8,4.8,0,0,1,22,8.967C22,11.87,19.053,16.006,13.915,20.313Z">
                    </path>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" class="svg-filled" viewBox="0 0 24 24">
                    <path d="M17.5,1.917a6.4,6.4,0,0,0-5.5,3.3,6.4,6.4,0,0,0-5.5-3.3A6.8,6.8,0,0,0,0,8.967c0,4.547,4.786,9.513,8.8,12.88a4.974,4.974,0,0,0,6.4,0C19.214,18.48,24,13.514,24,8.967A6.8,6.8,0,0,0,17.5,1.917Z">
                    </path>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" height="100" width="100" class="svg-celebrate">
                    <polygon points="10,10 20,20"></polygon>
                    <polygon points="10,50 20,50"></polygon>
                    <polygon points="20,80 30,70"></polygon>
                    <polygon points="90,10 80,20"></polygon>
                    <polygon points="90,50 80,50"></polygon>
                    <polygon points="80,80 70,70"></polygon>
                </svg>
            </div>
        
        </div> 
        <p id="errorrecenica" class="recenica" style="display:none;">Morate biti ulogovani da biste lajkovali !</p>
        <script>
            let recenica = document.getElementById("errorrecenica");
        $(document).ready(function() {
    $('#Give-It-An-Id').on('change', function() {
        if (this.checked) {
            // User checked the checkbox (liked the DJ)
            $.ajax({
                url: 'like.php', // Replace with your like handling script
                type: 'POST',
                data: { action: 'like' },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.status === 'liked') {
                        // alert("Zavoleli Ste mikulu");
                    } else {
                        
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error in AJAX request:", status, error);
                    // alert('Morate biti ulogovani da biste uradili ovu akciju');
                    recenica.style.display = 'block';
                    recenica.style.opacity = '0'; 
                    recenica.style.transition = 'opacity 1s ease';
                    recenica.offsetHeight;
                    recenica.style.opacity = '1'; 
                }
            });
        } else {
            // User unchecked the checkbox (unliked the DJ)
            $.ajax({
                url: 'like.php', // Replace with your unlike handling script
                type: 'POST',
                data: { action: 'unlike' },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.status === 'unliked') {
                        // alert("Ne volite mikulu vise");
                    } else {
                        // Handle error or other cases
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error in AJAX request:", status, error);
                    // alert('Error unliking the DJ');
                    
                    recenica.style.display = 'none';
                }
            });
        }
    });
});
    </script>
                                    
                                    <h6>
                                        Dj & Music Producer
                                    </h6>
                                    
                                    <p class="proile-rating">RANKINGS : <span>8/10</span></p>


                                    <?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "Sinke008";
$dbname = "login_db";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the DJ 'mikula' is live
$sql = "SELECT live FROM dj WHERE username = 'mikula'";
$result = $conn->query($sql);

// Check if there's a valid result
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $live = $row['live'];
} else {
    $live = 0; // If no result, set live to 0 (false)
}

// Close the database connection
$conn->close();
?>

<div class="live-status">
    <?php if ($live == 1): ?>
        <button class="button-8" id="openModalButton">Request a song</button>
        <div class="live-indicator"></div>
        <span class="live-text">DJ is live</span>
    <?php endif; ?>
</div>


<?php
// Start the session


// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "Sinke008";
$dbname = "djlikes";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (isset($_SESSION["user_id"])) {
    // Get the user ID from the session
    $user_id = $conn->real_escape_string($_SESSION["user_id"]);

    // Query to check if there are any rows for the user
    $sql = "SELECT * FROM song_requests WHERE user_id = '$user_id' AND played = '0'";
    $result = $conn->query($sql);

    // Fetch and display results
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div style='display: flex; align-items: center; margin-bottom: 15px; margin-top: 10px; gap: 10px;'>";
            
            // Cover image
            if (!empty($row['cover_image'])) {
                echo "<img src='" . htmlspecialchars($row['cover_image']) . "' alt='Cover Image' style='width: 50px; height: 50px; object-fit: cover; border-radius: 8px;'>";
            } else {
                echo "<div style='width: 50px; height: 50px; background-color: #ddd; border-radius: 8px; display: flex; justify-content: center; align-items: center; font-size: 12px;'>No Image</div>";
            }

            // Song details
            echo "<div>";
            echo "<h3 style='margin: 0; font-size: 15px; color: black;'>" . htmlspecialchars($row['song_name']) . "</h3>";
            echo "<p style='margin: 5px 0; font-size: 14px; color: black;'>Artist: " . htmlspecialchars($row['artist_name']) . "</p>";
            echo "</div>";

            // Status
            echo "<p style='margin: 0; font-size: 14px; color: black;'>Status: " . ($row['approved_by_dj'] ? "Approved" : "Pending") . "</p>";
            echo "</div>";
        }
    }
} else {
    // If user is not logged in, nothing will be displayed
}

// Close the database connection
$conn->close();
?>





















                                
                                    
<div id="songModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Search for a Song</h2>
        <input type="text" id="song-search" placeholder="Type a song name" onkeyup="searchSong()">
        <div id="search-results"></div>
    </div>
</div>

    

    <script>
        // Function to make the AJAX request for song search
        function searchSong() {
            var query = document.getElementById('song-search').value;

            if (query.length >= 3) {  // Start search only if query length is 3 or more
                $.ajax({
                    url: 'search_song.php',  // The PHP script to process the search request
                    type: 'GET',
                    data: { song: query },
                    success: function(response) {
                        // Show the search results in the #search-results div
                        $('#search-results').html(response);
                    }
                });
            } else {
                // Clear search results if the query is less than 3 characters
                $('#search-results').html('');
            }
        }
    </script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    // Listen for the button click to save a song
    const saveButtons = document.querySelectorAll('.save-song-btn');
    saveButtons.forEach(button => {
        button.addEventListener('click', function() {
            const song_name = button.getAttribute('data-song');
            const artist_name = button.getAttribute('data-artist');
            const album_name = button.getAttribute('data-album');
            const spotify_url = button.getAttribute('data-url');
            
            // Send the data via AJAX to a PHP handler
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'save_song.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);  // Show response (success or error)
                }
            };
            xhr.send(`song_name=${song_name}&artist_name=${artist_name}&album_name=${album_name}&spotify_url=${spotify_url}`);
        });
    });
});
</script>
<script>
    var modal = document.getElementById("songModal");

// Get the button that opens the modal
var btn = document.getElementById("openModalButton");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// Open the modal when the button is clicked
btn.onclick = function() {
    modal.style.display = "block";
}

// Close the modal when the user clicks the close button (X)
span.onclick = function() {
    modal.style.display = "none";
}

// Close the modal when the user clicks outside of it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

</script>



























                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Timeline</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="photos-tab" data-toggle="tab" href="#photos" role="tab" aria-controls="photos" aria-selected="false">Photos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="drama-tab" data-toggle="tab" href="#drama" role="tab" aria-controls="drama" aria-selected="false">Drama</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                    <button type="button" class="profile-edit-btn" id="playDemoBtn">
                        <i class="fas fa-play"></i> <span>Play Demo</span>
                    </button>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-4">
                    <div class="profile-work">
                       
                        <div id="profileContent" class="profile-content">
                            <p>WORK LINK</p>
                            <a href="">Instagram</a><br/>
                            <a href="">Facebook</a><br/>
                            <a href="">Spotify</a>
                            <p>SKILLS</p>
                            <a href="">Techno</a><br/>
                            <a href="">Tech House</a><br/>
                            <a href="">Pop</a><br/>
                            <a href="">Dance</a><br/>
                            <a href="">Electronic</a><br/>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                                
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Stage Name</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>Mikula</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Name</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>Danilo Srebro</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>bluvelvett1@gmail.com</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Phone</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>0638391630</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Profession</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>Web Developer, Designer & DJ</p>
                                            </div>
                                        </div>


                                        <div class="row maliekran">
                                            <div class="col-md-6">
                                                <label>Links & Skills</label>
                                            </div>
                                            <div class="col-md-6">
                                            <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                                            <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                                            <a href="#" class="social-icon"><i class="bi bi-spotify"></i></a>
                                                  <br>
                                                  
                                                    <a href="">Techno</a><br>
                                                    <a href="">Tech House</a><br>
                                                    <a href="">Pop</a><br>
                                                    <a href="">Dance</a><br>
                                                    <a href="">Electronic</a>
                                            </div>
                                        </div><br>

                                    



                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Bio</label><br/>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                                            </div>
                                        </div>
                            </div>


                            
                            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Day</th>
                                                        <th>Club</th>
                                                        <th>Start Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Monday</td>
                                                        <td>Club XYZ</td>
                                                        <td>10:00 PM</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tuesday</td>
                                                        <td>Club ABC</td>
                                                        <td>09:00 PM</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Wednesday</td>
                                                        <td>Club 123</td>
                                                        <td>11:00 PM</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Thursday</td>
                                                        <td>Club DEF</td>
                                                        <td>08:00 PM</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Friday</td>
                                                        <td>Club GHI</td>
                                                        <td>10:30 PM</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Saturday</td>
                                                        <td>Club JKL</td>
                                                        <td>09:30 PM</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Sunday</td>
                                                        <td>Club MNO</td>
                                                        <td>07:00 PM</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>



                                <div class="tab-pane fade" id="photos" role="tabpanel" aria-labelledby="photos-tab">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 col-sm-6 galerija">
                                            <img src="../assets/img/djj.jpg" alt="DJ 1" class="img-fluid rounded shadow" onclick="showModal(this)">
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-sm-6 galerija">
                                            <img src="../assets/img/djjj.png" alt="DJ 2" class="img-fluid rounded shadow" onclick="showModal(this)">
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-sm-6 galerija">
                                            <img src="../assets/img/djservis.jpg" alt="DJ Service" class="img-fluid rounded shadow" onclick="showModal(this)">
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-sm-6 galerija position-relative">
                                            <img src="../assets/img/djservis.jpg" alt="Video 2" class="img-fluid rounded shadow" onclick="showModal(this, 'video')" data-video-src="../assets/video/test.mp4">
                                            <div class="play-button" onclick="showModal(this.previousElementSibling, 'video')">
                                                <i class="bi bi-play-circle"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-sm-6 galerija position-relative">
                                            <img src="../assets/img/pravapoz.jpg" alt="Video 2" class="img-fluid rounded shadow" onclick="showModal(this, 'video')" data-video-src="../assets/video/test3.mp4">
                                            <div class="play-button" onclick="showModal(this.previousElementSibling, 'video')">
                                                <i class="bi bi-play-circle"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-sm-6 galerija position-relative">
                                            <img src="../assets/img/unutraaa.jpg" alt="Video 2" class="img-fluid rounded shadow" onclick="showModal(this, 'video')" data-video-src="../assets/video/test5.mp4">
                                            <div class="play-button" onclick="showModal(this.previousElementSibling, 'video')">
                                                <i class="bi bi-play-circle"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <div class="tab-pane fade" id="drama" role="tabpanel" aria-labelledby="drama-tab">
                                    
                                <?php
// Database connection details for both databases
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = "Sinke008"; // Replace with your MySQL password
$database1 = "djlikes"; // Database for reviews
$database2 = "login_db"; // Database for user information

// Create connection for the first database (reviews)
$conn1 = new mysqli($servername, $username, $password, $database1);

// Check connection for reviews
if ($conn1->connect_error) {
    die("Connection to 'djlikes' failed: " . $conn1->connect_error);
}

// Create connection for the second database (users)
$conn2 = new mysqli($servername, $username, $password, $database2);

// Check connection for users
if ($conn2->connect_error) {
    die("Connection to 'login_db' failed: " . $conn2->connect_error);
}

// Default image URL if no profile image is provided
$default_image = 'https://bootdey.com/img/Content/avatar/avatar7.png';

// SQL query to fetch reviews for DJ Mikula, along with user details (username and profile image) from the users table
$sql_reviews = "
    SELECT r.rating, r.review_text, r.user_id, u.username, u.profile_pic_url, r.review_date
    FROM `djlikes`.reviews r  -- specify the database for the reviews table
    LEFT JOIN `login_db`.user u ON r.user_id = u.id  -- specify the database for the users table
    WHERE r.dj_name = 'Mikula'
";

// Query execution for fetching reviews
$result_reviews = $conn1->query($sql_reviews);
?>

<!-- Reviews Section in the Mikula page -->

    <div class="reviews">
        <?php
        // Check if reviews exist and display each review
        if ($result_reviews->num_rows > 0) {
            while ($row_review = $result_reviews->fetch_assoc()) {
                // Check if user profile pic URL exists, otherwise use default
                $profile_img = ($row_review['profile_pic_url']) ? '../' . $row_review['profile_pic_url'] : $default_image;
                
                $thumbs_icon = ($row_review['rating'] == 'good') ? '👍' : '👎';
               
                echo "
    <div class='review'>
        <img src='" . $profile_img . "' alt='" . htmlspecialchars($row_review['username']) . "' class='review-img'>
        <div class='review-content'>
            <h4>" . htmlspecialchars($row_review['username']) . " $thumbs_icon</h4>
            <p>" . htmlspecialchars($row_review['review_text']) . "</p>
            <p class='review-date'>" . date('F j, Y', strtotime($row_review['review_date'])) . "</p>
        </div>
    </div>
";
            }
        } else {
            echo "<p>No reviews yet. Be the first to leave a review!</p>";
        }
        ?>
   
</div>

<?php
// Close the connections after use
$conn1->close();
$conn2->close();
?>

                                    <button id="review-btn" class="btn btn-primary">Leave a Review</button>
                                </div>




                                

<!-- Review Modal -->
<div id="review-modal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h2>Leave a Review for Mikula</h2>
        <form id="review-form" method="POST" action="submit_review.php">
           
            <div class="rating-choice">
                <label>
                    <input type="radio" name="rating" value="good" required> 
                    <span>Good</span>
                </label>
                <label>
                    <input type="radio" name="rating" value="bad" required> 
                    <span>Bad</span>
                </label>
            </div>

            <!-- Comment Input -->
            <div class="form-group">
                <textarea name="review_text" placeholder="Write your comment..." required></textarea>
            </div>


            <!-- Submit Button -->
            <button type="submit" class="btn-submit">Submit Review</button>
        </form>
    </div>
</div>





<!-- Modal -->
                                    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-body" id="modalBody">
                                                    <img src="" id="modalImage" class="img-fluid d-none" alt="">
                                                    <video id="modalVideo" class="w-100 d-none" controls autoplay>
                                                        <source id="modalVideoSource" src="" type="video/mp4"> <!-- .MP4 video type -->
                                                        Your browser does not support the video tag.
                                                    </video>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="stopVideo()">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                        </div>
                    </div>
                </div>
                       
        </div>
  

  

        <audio id="audioDemo" src="./uploads/demo_mp3/<?php echo htmlspecialchars($dj['demo_mp3']); ?>"></audio>


  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6">
            <div class="footer-info">
              <h3>Groovin</h3>
              <p>
                A108 Adam Street <br>
                NY 535022, USA<br><br>
                <strong>Phone:</strong> +1 5589 55488 55<br>
                <strong>Email:</strong> info@example.com<br>
              </p>
              <div class="social-links mt-3">
                <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Our Services</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
            </ul>
          </div>

          <div class="col-lg-4 col-md-6 footer-newsletter">
            <h4>Our Newsletter</h4>
            <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>
            <form action="" method="post">
              <input type="email" name="email"><input type="submit" value="Subscribe">
            </form>

          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>Groovin</span></strong>. All Rights Reserved
      </div>

    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>


  <script>
        var playDemoBtn = document.getElementById('playDemoBtn');
        var icon = playDemoBtn.querySelector('i');
        var buttonText = playDemoBtn.querySelector('span');
        var audio = document.getElementById('audioDemo');

        playDemoBtn.addEventListener('click', function() {
            if (audio.paused) {
                audio.play();
                icon.classList.remove('fa-play');
                icon.classList.add('fa-stop');
                playDemoBtn.classList.add('playing');
                buttonText.textContent = 'Stop Demo';
            } else {
                audio.pause();
                audio.currentTime = 0; // Reset to the beginning
                icon.classList.remove('fa-stop');
                icon.classList.add('fa-play');
                playDemoBtn.classList.remove('playing');
                buttonText.textContent = 'Play Demo';
            }
        });

        // Update button text and icon when audio ends (optional)
        audio.addEventListener('ended', function() {
            icon.classList.remove('fa-stop');
            icon.classList.add('fa-play');
            playDemoBtn.classList.remove('playing');
            buttonText.textContent = 'Play Demo';
        });
    </script>

<script>
        var playDemoBtnMali = document.getElementById('playDemoBtnMali');
        var iconMali = playDemoBtnMali.querySelector('i');
        var buttonTextMali = playDemoBtnMali.querySelector('span');
        var audioMali = document.getElementById('audioDemo');

        playDemoBtnMali.addEventListener('click', function() {
            if (audioMali.paused) {
                audioMali.play();
                iconMali.classList.remove('fa-play');
                iconMali.classList.add('fa-stop');
                playDemoBtnMali.classList.add('playing');
                buttonTextMali.textContent = 'Stop Demo';
            } else {
                audioMali.pause();
                audioMali.currentTime = 0; // Reset to the beginning
                iconMali.classList.remove('fa-stop');
                iconMali.classList.add('fa-play');
                playDemoBtnMali.classList.remove('playing');
                buttonTextMali.textContent = 'Play Demo';
            }
        });

        // Update button text and icon when audio ends (optional)
        audioMali.addEventListener('ended', function() {
            iconMali.classList.remove('fa-stop');
            iconMali.classList.add('fa-play');
            playDemoBtnMali.classList.remove('playing');
            buttonTextMali.textContent = 'Play Demo';
        });
    </script>


<script>
function showModal(element, type) {
    const modalImage = document.getElementById('modalImage');
    const modalVideo = document.getElementById('modalVideo');
    const modalVideoSource = document.getElementById('modalVideoSource');

    if (type === 'video') {
        modalImage.classList.add('d-none'); // Hide image
        modalVideo.classList.remove('d-none'); // Show video

        // Get video source from the data attribute
        const videoSrc = element.getAttribute('data-video-src');
        modalVideoSource.src = videoSrc; // Set the video source
        modalVideo.load(); // Load the new video
        modalVideo.play(); // Play the video
    } else {
        modalVideo.classList.add('d-none'); // Hide video
        modalImage.classList.remove('d-none'); // Show image
        modalImage.src = element.src; // Set the image source
    }

    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    modal.show();
}

function stopVideo() {
    const modalVideo = document.getElementById('modalVideo');
    modalVideo.pause(); // Pause video when closing modal
    modalVideo.currentTime = 0; // Reset to start
}
</script>


<script>
    // Open and close the modal
document.getElementById('review-btn').addEventListener('click', () => {
    document.getElementById('review-modal').style.display = 'block';
});

document.querySelector('.close-btn').addEventListener('click', () => {
    document.getElementById('review-modal').style.display = 'none';
});

// Close modal if the user clicks outside the content
window.addEventListener('click', (event) => {
    const modal = document.getElementById('review-modal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});

</script>



<script>
    $(document).ready(function() {
        // When the review form is submitted
        $('#review-form').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Collect form data
            var formData = $(this).serialize(); // Serialize form data (turn it into a query string)

            // Send the form data using AJAX
            $.ajax({
                url: 'submit_review.php',
                type: 'POST',
                data: formData,
                dataType: 'json', // Expecting JSON response
                success: function(response) {
                    // Check if the response status is success
                    if (response.status === 'success') {
                        // Show success message (e.g., on the page or as a popup)
                        alert(response.message);
                    } else {
                        // Show error message
                        alert(response.message);
                    }
                },
                error: function() {
                    // Handle AJAX errors
                    alert('An error occurred while submitting the review.');
                }
            });
        });
    });
</script>
  

</body>

</html>