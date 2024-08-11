<?php
header('Content-Type: application/json');

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['message' => 'Connection failed: ' . $conn->connect_error]));
}

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['id']) && isset($input['rental_end_time'])) {
    $id = $conn->real_escape_string($input['id']);
    $rental_end_time = $conn->real_escape_string($input['rental_end_time']);

    $query = "UPDATE livros SET status_livros = 1, rental_end_time = ? WHERE id = ? AND status_livros = 0";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $rental_end_time, $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['message' => 'Book rented successfully']);
        } else {
            echo json_encode(['message' => 'Book not found or already rented']);
        }
    } else {
        echo json_encode(['message' => 'Error updating book status']);
    }

    $stmt->close();
} else {
    echo json_encode(['message' => 'Invalid request data']);
}

$conn->close();
?>
