<?php
header('Access-Control-Allow-Origin: *'); // Permite requisições de qualquer origem
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS'); // Permite os métodos HTTP desejados
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Permite os cabeçalhos desejados
header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

// Configurações do banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Obtém o ID do livro e o tempo de término do corpo da solicitação
$input = json_decode(file_get_contents("php://input"), true);
$bookId = isset($input['id']) ? intval($input['id']) : 0;
$rentalEndTime = isset($input['rentalEndTime']) ? $input['rentalEndTime'] : null;

if ($bookId > 0 && $rentalEndTime) {
    $sql = "UPDATE livros SET status_livros = 1, rental_end_time = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("si", $rentalEndTime, $bookId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Failed to update rental status']);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Failed to prepare SQL statement']);
    }
} else {
    echo json_encode(['error' => 'Invalid parameters']);
}

$conn->close();
?>
