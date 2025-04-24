
<?php

$servername = "localhost";
$username = "root";
$password = "Sinke008";
$dbname = "zaunadmin";



$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (!isset($_COOKIE['has_visited'])) {
   

   
    $sql = "UPDATE page_views SET count = count + 1 WHERE id = 1";
    $conn->query($sql);

    
    setcookie('has_visited', true, time() + (86400 * 30), "/");  // 86400 = 1 day
}




$sql = "UPDATE page_views SET count = count + 1 WHERE id = 2";
$conn->query($sql);



// Retrieve the updated count from the database
$sql = "SELECT count FROM page_views WHERE id = 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();


$sql2 = "SELECT count FROM page_views WHERE id = 2";
$result2 = $conn->query($sql2);
$row2 = $result2->fetch_assoc();

// Display the visit count


// Close the connection
$conn->close();
?>


<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Danilo Srebro</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital@1&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=BhuTuka+Expanded+One&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Smooch+Sans&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

 

</head>
<body>

    
    <main id="main">
        <section class="landing">

        

            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="profile-card">
                           
                         
            
                            <div class="profile-image mb-3">
                                <img src="./IMG_0646.jpeg" alt="Profile Image">
                            </div>
            
                           
                            <h1 class="mb-2">Danilo Srebro</h1>
                            <p class="text-muted">Frontend Developer</p>
            
                            <p>from Novi Sad, Serbia</p>

                           
                         
                            <p>Seeking every oportunity as an adventure.</p>

            
                          
                            <div class="skills">
                                <span class="badge badge-primary skills1">HTML5 & CSS3</span>
                                <span class="badge badge-info skills2">MySql</span>
                                <span class="badge badge-success skills3">PHP</span>
                                <span class="badge badge-danger skills4">JavaScript</span>
                                
                            </div>
                        </div>
                        
                    </div>



                </div>
            </div>



            <div class="container mt-5">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="profile-card1">
                            
                            <h3>Education</h3>
                            <ul>
                                <li><strong>Complete Ethical Hacking Bootcamp
                                </strong> - ZTM Academy</li><br>
                                <li><strong>Professional Engineer of Information Technologies and Systems</strong> - Higher Technical School of Professional Studies</li> <br>
                                <li><strong>Technical School</strong> - Electronics Program</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="profile-card1">
                            <h3>Experience</h3>
                            <br>
                            <br>
                            <ul>
                               
                                <li><strong>Intern</strong> - CP Distribution - 2 months <br>Frontend design and development.</li>
                                
                            </ul>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
            </div>




            <div class="container mt-1">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="profile-card1">
                            <h3>Projects</h3>
                            <p><strong>Project Name:</strong> Restaurant Reservation System</p>
                            
                            <p><strong>Project Description:</strong> This restaurant reservation system allows users to easily book tables at various restaurants in Novi Sad. Users can enter their information, select a restaurant, date, and time for the reservation. Once the reservation is confirmed, users receive a notification via email.</p>
                        
                            <p><strong>Technologies Used:</strong></p>
                            <ul>
                                <li><strong>Frontend:</strong> <span class="badge badge-primary">HTML5 & CSS3</span> <span class="badge badge-danger">JavaScript</span></li>
                                <li><strong>Backend:</strong> <span class="badge badge-info">PHP</span> <span class="badge badge-warning">AJAX</span></li>
                                <li><strong>Database:</strong> <span class="badge badge-secondary">MySql</span></li>
                                <li><strong>Server:</strong> <span class="badge badge-success">Node.js</span> <br>(for sending email confirmations)</li>
                            </ul>
                        
                            <p><strong>Security Features:</strong></p>
                            <ul>
                                <li>HTTPS for secure communication</li>
                                <li>CSRF tokens for secure form submissions</li>
                                <li>Honeypot fields to prevent bot submissions</li>
                                <li>IP rate limiting for better protection against abuse</li>
                                <li>Captcha implementation for additional verification</li>
                                <li>User login functionality with secure password handling</li>
                                <li>SHA-256 algorithm for hashing passwords</li>
                            </ul>
                        
                            <p><strong>Key Features:</strong></p>
                            <ul>
                                <li>User interface for easy reservations</li>
                                <li>Reservation management system with the ability to view, approve/reject, change the information and delete reservations</li>
                                <li>Automatic email confirmations sent to users</li>
                                <li>Point accumulation for users who honor their reservations</li>
                            </ul>
                        
                            <p><strong>Project Goal:</strong> The goal of this project is to enhance the user experience when booking tables, reduce the need for phone calls, and improve restaurant management organization.</p>
                        </div> 
                    </div>
                </div>
            </div>



            <div class="container mt-1">
                <div class="row">
                <div class="col-lg-9">
                        <div class="profile-card1">
                        <h3>About Me</h3>
                        <p>Passionate about web developing and design.</p>
                        <p>Date of birth: 04.02.2001.</p>
                        <p>Phone Number: 063/8391-630</p>
                        <p>Email: bluvelvett1@gmail.com</p>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="profile-card1">
                        <h3>Skills</h3>
                        <ul>
                            <li>HTML & CSS</li>
                            <li>PHP</li>
                            <li>MySQL</li>
                            <li>JavaScript</li>
                            <li>LInux Basics</li>
                            <li>Wix & Wordpress</li>
                        </ul>
                        
                        </div>
                    </div>

                    
                </div>
            </div>


           

            <div class="container mt-1">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="profile-card1">
                        <h3><i class="bi bi-door-open" style="color:aquamarine"></i></h3>
                        
                        <p>I am currently open for volunteering and internship opportunities, where I can leverage my skills  to meaningful projects while gaining valuable experience in my field.</p>

                       
                            


                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="profile-card1">
                        <h3><i class="bi bi-car-front" style="color:orange"></i></h3>
                        <p>Driver with a category B license.</p>
                        <p>I have my own car.</p>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="profile-card1">
                        <h3><i class="bi bi-translate" style="color: lightskyblue"></i></h3>
                        <p>Adnvanced knowledge of english language.</p>

                        <p>Currently studying Spanish.</p>
                       
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="profile-card1">
                        <h3><i class="bi bi-file-earmark-code" style="color: salmon"></i></h3>
                        <br>
                        <p style="padding-bottom: 7.5px;padding-top: 7.5px;"><strong>Complete Ethical Hacking Bootcamp
                                </strong> - ZTM Academy</p>
                                <br>
                        </div>
                    </div>

                    <div class="col-lg-12">
                    <div class="profile-card1">
                        <h3>Restaurant Experience</h3>

                            <ul> 
                                <li>
                                    <strong>Chef</strong> - Točionica Pab - 4 months <br>
                                    Prepared high-quality meals while maintaining kitchen standards. <br>
                                    Thrived in a collaborative team environment, ensuring efficient food service and guest satisfaction.
                                </li> 
                            <br>
                                <li>
                                    <strong>Assistant Chef</strong> - Čarda kod Braše - 6 months <br>
                                    Consistently prepared high-quality meals while maintaining strict kitchen standards. <br>
                                    Collaborated effectively with the team to ensure smooth kitchen operations.
                                </li>
                            </ul>



                        </div>
                    </div>

                    
                </div>
            </div>

            <div class="container mt-1">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="profile-card1">
                        <h3><i class="bi bi-eye"></i></h3>
                        <?php
                            echo "<p>This page has been visited " . $row2['count'] . " times.</p>";
                            ?>
                        <?php
                            echo "<p>This page has been visited " . $row['count'] . " times by distinct users.</p>";
                            ?>
                       
                            


                        </div>
                    </div>
                </div>
            </div>

            <div class="container mt-1">
    <div class="row">
        <div class="col-lg-12">
            <div class="profile-card1">
                
                <h3>Blender Project</h3>

                <!-- Video Thumbnail -->
                <a href="#" data-bs-toggle="modal" data-bs-target="#videoModal">
                    <img src="./image.png" alt="Video Thumbnail" class="img-fluid" style="cursor: pointer;">
                    <i class="bi bi-play-circle play-icon"></i>
                </a>

                <!-- Video Modal -->
                

            </div>
        </div>
    </div>
</div>

                       
<div class="modal fade video-modal" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="videoModalLabel">Blender Project Video</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <video id="videoPlayer" controls width="100%">
                                    <source src="./blender.mp4" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>
                    </div>
                </div>     


                        </div>
                    </div>
                </div>
            </div>





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
        
        </section>
        
    </main>


    <div class="intro">
        <div class="intro-text">
            <h1 class="hide">
                <span class="text">Welcome</span>
            </h1>
            <h1 class="hide">
                <span class="text">To</span>
            </h1>
            <h1 class="hide">
                <span class="text">my World</span>
            </h1>
        </div>
    </div>
    <div class="slider"></div>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js" integrity="sha512-H6cPm97FAsgIKmlBA4s774vqoN24V5gSQL4yBTDOY2su2DeXZVhQPxFK4P6GPdnZqM9fg1G3cMv5wD7e6cFLZQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="./app.js"></script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
    var videoModal = document.getElementById('videoModal');
    var videoPlayer = document.getElementById('videoPlayer');

    videoModal.addEventListener('show.bs.modal', function () {
        videoPlayer.play();
    });

    videoModal.addEventListener('hide.bs.modal', function () {
        videoPlayer.pause();
        videoPlayer.currentTime = 0;
    });
});
    </script>

</body>
</html>