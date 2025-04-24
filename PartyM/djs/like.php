<?php
session_start();

if (!isset($_SESSION["user_id"]) || !isset($_POST['id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(array("status" => "error", "message" => "User not logged in or DJ ID is missing"));
    exit;
}

$action = $_POST['action'] ?? '';
$id = $_POST['id']; // DJ ID passed through POST request

if (empty($id)) {
    http_response_code(400); // Bad request
    echo json_encode(array("status" => "error", "message" => "DJ ID is required"));
    exit;
}

$mysqli = new mysqli('localhost', 'root', 'Sinke008', 'djlikes');
if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

$user_id = $_SESSION["user_id"];

if ($action === 'like') {
    // Handle 'like' action (insert user_id and dj_id into the likes table)
    $stmt = $mysqli->prepare('INSERT INTO mikula (user_id, dj_id) VALUES (?, ?)');
    $stmt->bind_param('ii', $user_id, $id);
    if ($stmt->execute()) {
        echo json_encode(array("status" => "liked"));
    } else {
        echo json_encode(array("status" => "error", "message" => "Failed to like DJ"));
    }
    $stmt->close();
} elseif ($action === 'unlike') {
    // Handle 'unlike' action (delete user_id and dj_id from the mikula table)
    $stmt = $mysqli->prepare('DELETE FROM mikula WHERE user_id = ? AND dj_id = ?');
    $stmt->bind_param('ii', $user_id, $id);
    if ($stmt->execute()) {
        echo json_encode(array("status" => "unliked"));
    } else {
        echo json_encode(array("status" => "error", "message" => "Failed to unlike DJ"));
    }
    $stmt->close();
} else {
    http_response_code(400); // Bad request
    echo json_encode(array("status" => "error", "message" => "Invalid action"));
    exit;
}

$mysqli->close();
?>
