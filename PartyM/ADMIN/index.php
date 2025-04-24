<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "Sinke008";
$dbname = "login_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to count the number of rows in the users table
$sql = "SELECT COUNT(*) as total FROM user";
$result = $conn->query($sql);

// Fetch the count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $users = $row['total'];
} else {
    $users = 0;
}

$userpercentage = ($users / 1000) * 100;
// Close the connection
$conn->close();
?>
<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "Sinke008";
$dbname = "login_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to count the number of rows in the users table
$sql = "SELECT COUNT(*) as total FROM manager";
$result = $conn->query($sql);

// Fetch the count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $manager = $row['total'];
} else {
    $manager = 0;
}

$managerpercentage = ($manager / 1000) * 100;
// Close the connection
$conn->close();
?>

<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "Sinke008";
$dbname = "rezervacije";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to count the number of rows in the users table
$sql = "SELECT COUNT(*) as total FROM tocionica";
$result = $conn->query($sql);

// Fetch the count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $tocionica = $row['total'];
} else {
    $tocionica = 0;
}

$tocionicapercentage = ($tocionica / 1000) * 100;
// Close the connection
$conn->close();
?>

<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "Sinke008";
$dbname = "rezervacije";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to count the number of rows in the users table
$sql = "SELECT COUNT(*) as total FROM tocionicaistorija";
$result = $conn->query($sql);

// Fetch the count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $tocionicaistorija = $row['total'];
} else {
    $tocionicaistorija = 0;
}

$tocionicaistorijapercentage = ($tocionicaistorija / 1000) * 100;
// Close the connection
$conn->close();
?>

<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "Sinke008";
$dbname = "zaunadmin";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to count the number of rows in the users table
$sql = "SELECT count as uniqueusers FROM page_views WHERE id='1'";
$result = $conn->query($sql);

// Fetch the count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $users1= $row['uniqueusers'];
} else {
    $users1 = 0;
}

$sql2 = "SELECT count as uniqueusers FROM page_views WHERE id='2'";
$result2 = $conn->query($sql2);

// Fetch the count
if ($result2->num_rows > 0) {
    $row2 = $result2->fetch_assoc();
    $users2= $row2['uniqueusers'];
} else {
    $users2 = 0;
}

$sql3 = "SELECT count as uniqueusers FROM page_views WHERE id='3'";
$result3 = $conn->query($sql3);

// Fetch the count
if ($result3->num_rows > 0) {
    $row3 = $result3->fetch_assoc();
    $users3= $row3['uniqueusers'];
} else {
    $users3 = 0;
}

$sql4 = "SELECT count as uniqueusers FROM page_views WHERE id='4'";
$result4 = $conn->query($sql4);

// Fetch the count
if ($result4->num_rows > 0) {
    $row4 = $result4->fetch_assoc();
    $users4= $row4['uniqueusers'];
} else {
    $users4 = 0;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />

    <title>Party M1000</title>

    <style>
        .card {
    background-color: #fff;
    border-radius: 10px;
    border: none;
    position: relative;
    margin-bottom: 30px;
    box-shadow: 0 0.46875rem 2.1875rem rgba(90,97,105,0.1), 0 0.9375rem 1.40625rem rgba(90,97,105,0.1), 0 0.25rem 0.53125rem rgba(90,97,105,0.12), 0 0.125rem 0.1875rem rgba(90,97,105,0.1);
}
.l-bg-cherry {
    background: linear-gradient(to right, #493240, #f09) !important;
    color: #fff;
}

.l-bg-blue-dark {
    background: linear-gradient(to right, #373b44, #4286f4) !important;
    color: #fff;
}

.l-bg-green-dark {
    background: linear-gradient(to right, #0a504a, #38ef7d) !important;
    color: #fff;
}

.l-bg-orange-dark {
    background: linear-gradient(to right, #a86008, #ffba56) !important;
    color: #fff;
}

.card .card-statistic-3 .card-icon-large .fas, .card .card-statistic-3 .card-icon-large .far, .card .card-statistic-3 .card-icon-large .fab, .card .card-statistic-3 .card-icon-large .fal {
    font-size: 110px;
}

.card .card-statistic-3 .card-icon {
    text-align: center;
    line-height: 50px;
    margin-left: 15px;
    color: #000;
    position: absolute;
    right: -5px;
    top: 20px;
    opacity: 0.1;
}

.l-bg-cyan {
    background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
    color: #fff;
}

.l-bg-green {
    background: linear-gradient(135deg, #23bdb8 0%, #43e794 100%) !important;
    color: #fff;
}

.l-bg-orange {
    background: linear-gradient(to right, #f9900e, #ffba56) !important;
    color: #fff;
}

.l-bg-cyan {
    background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
    color: #fff;
}


.portfolio {
    margin-top: 20px;
}

.stats-box {
    background-color: #f7f7f7; /* Light background for contrast */
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease-in-out;
}

.stats-box:hover {
    transform: translateY(-5px); /* Adds a subtle lift effect on hover */
}

.stats-title {
    font-size: 1.2rem;
    font-weight: bold;
    color: #4b137d; /* Main color you prefer */
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 10px;
}

.stats-value {
    font-size: 1.5rem;
    color: #333; /* Neutral text color */
    font-weight: 600;
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .stats-box {
        margin-bottom: 15px;
    }
}

    </style>
</head>
<body>

<br>
    
    
    <div class="container">
        <div class="row ">
            <div class="col-xl-6 col-lg-6">
                <div class="card l-bg-blue-dark">
                    <div class="card-statistic-3 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">Users</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h2 class="d-flex align-items-center mb-0">
                                <?php echo $users; ?>
                                </h2>
                            </div>
                            <div class="col-4 text-right">
                                <span><?php echo number_format($userpercentage, 2); ?>% <i class="fa fa-arrow-up"></i></span>
                            </div>
                        </div>
                        <div class="progress mt-1 " data-height="8" style="height: 8px;">
                            <div class="progress-bar l-bg-green" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo number_format($userpercentage, 2); ?>%;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6">
                <div class="card l-bg-cherry">
                    <div class="card-statistic-3 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-user-shield"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">Managers</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h2 class="d-flex align-items-center mb-0">
                                <?php echo $manager; ?>
                                </h2>
                            </div>
                            <div class="col-4 text-right">
                                <span><?php echo number_format($managerpercentage, 2); ?>% <i class="fa fa-arrow-up"></i></span>
                            </div>
                        </div>
                        <div class="progress mt-1 " data-height="8" style="height: 8px;">
                            <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo number_format($managerpercentage, 2); ?>%;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6">
                <div class="card l-bg-green-dark">
                    <div class="card-statistic-3 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-ticket-alt"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">Reservations</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h2 class="d-flex align-items-center mb-0">
                                <?php echo $tocionica; ?>
                                </h2>
                            </div>
                            <div class="col-4 text-right">
                                <span><?php echo number_format($tocionicapercentage, 2); ?>% <i class="fa fa-arrow-up"></i></span>
                            </div>
                        </div>
                        <div class="progress mt-1 " data-height="8" style="height: 8px;">
                            <div class="progress-bar l-bg-orange" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo number_format($tocionicapercentage, 2); ?>%;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6">
                <div class="card l-bg-orange-dark">
                    <div class="card-statistic-3 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-dollar-sign"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">Been Reservations</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h2 class="d-flex align-items-center mb-0">
                                <?php echo $tocionicaistorija; ?>
                                </h2>
                            </div>
                            <div class="col-4 text-right">
                                <span><?php echo number_format($tocionicaistorijapercentage, 2); ?>% <i class="fa fa-arrow-up"></i></span>
                            </div>
                        </div>
                        <div class="progress mt-1 " data-height="8" style="height: 8px;">
                            <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo number_format($tocionicaistorijapercentage, 2); ?>%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="row portfolio">
    <div class="col-lg-3 col-6 stats-box">
        <h4 class="stats-title">Distinct Visits</h4>
        <p class="stats-value"><?php echo $users1; ?></p>
    </div>
    <div class="col-lg-3 col-6 stats-box">
        <h4 class="stats-title">All Visits</h4>
        <p class="stats-value"><?php echo $users2; ?></p>
    </div>
    <div class="col-lg-3 col-6 stats-box">
        <h4 class="stats-title">LinkedIn Visits</h4>
        <p class="stats-value"><?php echo $users3; ?></p>
    </div>
    <div class="col-lg-3 col-6 stats-box">
        <h4 class="stats-title">Distinct LinkedIn Visits</h4>
        <p class="stats-value"><?php echo $users4; ?></p>
    </div>
</div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>