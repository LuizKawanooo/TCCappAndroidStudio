<?php
header("Access-Control-Allow-Origin: *"); // Allows access from any domain
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allowed methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allowed headers
header("Content-Type: application/json"); // Ensure the response is in JSON format

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and validate book ID
    $bookId = isset($_POST['book_id']) ? intval($_POST['book_id']) : 0;

    if ($bookId <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid book ID']);
        exit();
    }

    // Fetch current status of the book
    $query = "SELECT status_livros, rental_end_time FROM livros WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $stmt->bind_result($statusLivros, $rentalEndTime);
    $stmt->fetch();
    $stmt->close();

    if ($statusLivros === null) {
        echo json_encode(['status' => 'error', 'message' => 'Book not found']);
        exit();
    }

    // Check if the book is available (status 0) or rented and the timer expired
    $currentTime = new DateTime();
    $isAvailable = $statusLivros == 0 || ($statusLivros == 1 && new DateTime($rentalEndTime) <= $currentTime);

    if ($isAvailable) {
        // Update status to 1 and set rental_end_time to 30 seconds from now
        $rentalEndTime = $currentTime->add(new DateInterval('PT30S'))->format('Y-m-d H:i:s');
        $updateQuery = "UPDATE livros SET status_livros = 1, rental_end_time = ? WHERE id = ?";
        $updateStmt = $mysqli->prepare($updateQuery);
        $updateStmt->bind_param("si", $rentalEndTime, $bookId);
        $updateStmt->execute();
        $updateStmt->close();

        echo json_encode(['status' => 'success', 'rental_end_time' => $rentalEndTime]);
    } else {
        echo json_encode(['status' => 'unavailable']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
