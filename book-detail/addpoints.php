// <?php
// // Enable error reporting
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// header('Content-Type: application/json');
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
// header('Access-Control-Allow-Headers: Content-Type');

// $servername = "tccappionic-bd.mysql.uhserver.com";
// $username = "ionic_perfil_bd";
// $password = "{[UOLluiz2019";
// $dbname = "tccappionic_bd";

// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);

// // Check connection
// if ($conn->connect_error) {
//     echo json_encode(array("message" => "Connection failed: " . $conn->connect_error));
//     exit();
// }

// // Get user ID from query parameters
// $userId = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

// // Ensure the user ID is valid
// if ($userId <= 0) {
//     echo json_encode(array("message" => "Invalid user ID"));
//     $conn->close();
//     exit();
// }

// // Query to add 100 points to the user’s points
// $updateSql = "UPDATE registrar_usuarios SET pontos = pontos + 100 WHERE id = ?";
// $updateStmt = $conn->prepare($updateSql);

// if ($updateStmt === false) {
//     echo json_encode(array("message" => "Failed to prepare the SQL update statement: " . $conn->error));
//     $conn->close();
//     exit();
// }

// // Bind the user ID to the query
// $updateStmt->bind_param("i", $userId);
// $updateStmt->execute();

// if ($updateStmt->affected_rows > 0) {
//     echo json_encode(array("message" => "100 points added successfully"));
// } else {
//     // Check if the user exists
//     if ($conn->affected_rows === 0) {
//         echo json_encode(array("message" => "User not found or points not updated"));
//     } else {
//         echo json_encode(array("message" => "Failed to add points, please try again later"));
//     }
// }

// $updateStmt->close();
// $conn->close();
// ?>




<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Database connection
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(array("status" => "error", "message" => "Connection failed: " . $conn->connect_error));
    exit();
}

// Get user ID and points from POST data
$data = json_decode(file_get_contents("php://input"), true);
$userId = isset($data['userId']) ? intval($data['userId']) : 0;
$points = isset($data['points']) ? intval($data['points']) : 0;

// Ensure user ID and points are valid
if ($userId <= 0 || $points <= 0) {
    echo json_encode(array("status" => "error", "message" => "Invalid user ID or points."));
    $conn->close();
    exit();
}

// Update points in the database
$updateSql = "UPDATE registrar_usuarios SET pontos = pontos + ? WHERE id = ?";
$stmt = $conn->prepare($updateSql);
$stmt->bind_param("ii", $points, $userId);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(array("status" => "success", "message" => "Points added successfully."));
} else {
    echo json_encode(array("status" => "error", "message" => "Failed to add points."));
}

$stmt->close();
$conn->close();
?>
