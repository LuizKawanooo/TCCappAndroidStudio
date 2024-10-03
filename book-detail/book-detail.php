
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
$userId = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

// Ensure the book ID and user ID are valid
if ($bookId <= 0 || $userId <= 0) {
    echo json_encode(array("message" => "Invalid book ID or user ID"));
    $conn->close();
    exit();
}

// Query to fetch book details
$sql = "SELECT `id`, `titulo`, `genero`, `autor`, `editora`, `tombo`, `ano`, `classificacao`, `n_paginas`, `isbn`, `sinopse` FROM livros WHERE id = ?";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(array("message" => "Failed to prepare the SQL statement: " . $conn->error));
    $conn->close();
    exit();
}

$stmt->bind_param("i", $bookId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $book = $result->fetch_assoc();

    // Add 100 points to the user's points by calling addpoints.php
    $addPointsUrl = "https://endologic.com.br/book-detail/addpoints.php?user_id=$userId&book_id=$bookId";
    
    // Execute the request to add points
    $response = file_get_contents($addPointsUrl);
    $pointsResponse = json_decode($response, true);

    if (isset($pointsResponse['message']) && $pointsResponse['message'] === "100 points added successfully") {
        echo json_encode(array(
            "message" => "Book rented successfully, 100 points added",
            "book" => $book
        ));
    } else {
        echo json_encode(array("message" => "Book rented successfully, but failed to add points"));
    }
    
} else {
    echo json_encode(array("message" => "Book not found"));
}

$stmt->close();
$conn->close();
?>
