<?php
header('Content-Type: application/json');

// Configurações do banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtém o ID do livro e o tempo de término do corpo da solicitação
$input = json_decode(file_get_contents("php://input"), true);
$bookId = isset($input['id']) ? intval($input['id']) : 0;
$rentalEndTime = isset($input['rentalEndTime']) ? $input['rentalEndTime'] : null;

if ($bookId > 0 && $rentalEndTime) {
    $sql = "UPDATE livros SET status_livros = 1, rental_end_time = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $rentalEndTime, $bookId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Failed to update rental status']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Invalid parameters']);
}

$conn->close();
?>
