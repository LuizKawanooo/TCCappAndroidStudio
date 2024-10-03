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

// Get user ID and book ID from query parameters
$userId = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
$bookId = isset($_GET['book_id']) ? intval($_GET['book_id']) : 0;

// Ensure both user ID and book ID are valid
if ($userId <= 0 || $bookId <= 0) {
    echo json_encode(array("message" => "Invalid user ID or book ID"));
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
    echo json_encode(array("message" => "Failed to add points"));
}

$updateStmt->close();
$conn->close();
?>
