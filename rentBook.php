<?php
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookId = $_POST['book_id'];

    // Fetch current status of the book
    $query = "SELECT status_livros, rental_end_time FROM livros WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $stmt->bind_result($statusLivros, $rentalEndTime);
    $stmt->fetch();
    $stmt->close();

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
}
