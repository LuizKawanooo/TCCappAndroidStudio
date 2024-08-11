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

// Obtém o ID do livro da URL
$bookId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($bookId > 0) {
    $sql = "SELECT status_livros, rental_end_time FROM livros WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $isRented = $row['status_livros'] == 1;
        $response = [
            'isRented' => $isRented,
            'rentalEndTime' => $isRented ? $row['rental_end_time'] : null
        ];
        echo json_encode($response);
    } else {
        echo json_encode(['error' => 'Book not found']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Invalid book ID']);
}

$conn->close();
?>
