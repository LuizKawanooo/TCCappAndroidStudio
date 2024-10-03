<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(array("message" => "Connection failed: " . $conn->connect_error));
    exit();
}

// Get user ID from query parameters
$data = json_decode(file_get_contents("php://input"), true);
$userId = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

// Ensure the user ID is valid
if ($userId <= 0) {
    echo json_encode(array("message" => "Invalid user ID"));
    $conn->close();
    exit();
}

// Query to add 100 points to the user’s points
$updateSql = "UPDATE registrar_usuarios SET pontos = pontos + 100 WHERE id = ?";
$updateStmt = $conn->prepare($updateSql);

if ($updateStmt === false) {
    echo json_encode(array("message" => "Failed to prepare the SQL update statement: " . $conn->error));
    $conn->close();
    exit();
}

// Bind the user ID to the query
$updateStmt->bind_param("i", $userId);
$updateStmt->execute();

if ($updateStmt->affected_rows > 0) {
    echo json_encode(array("message" => "100 points added successfully"));
} else {
    // Check if the user exists
    if ($conn->affected_rows === 0) {
        echo json_encode(array("message" => "User not found or points not updated"));
    } else {
        echo json_encode(array("message" => "Failed to add points, please try again later"));
    }
}

$updateStmt->close();
$conn->close();
?>
