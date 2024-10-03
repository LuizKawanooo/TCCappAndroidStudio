
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

// // Get book ID from query parameter
// $bookId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// // Ensure the book ID is valid
// if ($bookId <= 0) {
//     echo json_encode(array("message" => "Invalid book ID"));
//     $conn->close();
//     exit();
// }

// // Query to fetch book details
// $sql = "SELECT `id` ,`titulo`, `genero`, `autor`, `editora`, `tombo`, `ano`, `classificacao`, `n_paginas`, `isbn`, `sinopse` FROM livros WHERE id = ?";

// $stmt = $conn->prepare($sql);

// if ($stmt === false) {
//     echo json_encode(array("message" => "Failed to prepare the SQL statement: " . $conn->error));
//     $conn->close();
//     exit();
// }

// $stmt->bind_param("i", $bookId);
// $stmt->execute();
// $result = $stmt->get_result();

// if ($result->num_rows > 0) {
//     $book = $result->fetch_assoc();
//     echo json_encode($book);
// } else {
//     echo json_encode(array("message" => "Book not found"));
// }

// $stmt->close();
// $conn->close();
// ?>














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

// Get book ID and user ID from query parameters
$bookId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$userId = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0; // Assuming you're passing the user ID

// Ensure the book ID and user ID are valid
if ($bookId <= 0 || $userId <= 0) {
    echo json_encode(array("message" => "Invalid book ID or user ID"));
    $conn->close();
    exit();
}

// Check if the book is available
$sqlCheck = "SELECT status_livros FROM livros WHERE id = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("i", $bookId);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

if ($resultCheck->num_rows > 0) {
    $bookStatus = $resultCheck->fetch_assoc()['status_livros'];

    if ($bookStatus == 0) { // If the book is available
        // Update the book status to rented
        $sqlUpdate = "UPDATE livros SET status_livros = 1, rental_start_time = NOW(), rental_end_time = DATE_ADD(NOW(), INTERVAL 30 SECOND) WHERE id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("i", $bookId);
        $stmtUpdate->execute();

        // Execute addpoints.php
        include 'addpoints.php'; // Make sure addpoints.php handles the logic correctly

        echo json_encode(array("message" => "Book rented successfully, points added."));
    } else {
        echo json_encode(array("message" => "Book is already rented."));
    }
} else {
    echo json_encode(array("message" => "Book not found"));
}

$stmtCheck->close();
$conn->close();
?>
