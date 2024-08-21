<?php
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Recebe a solicitação do cliente
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['id'])) {
    $livroId = $conn->real_escape_string($input['id']);

    $stmt = $conn->prepare("DELETE FROM livro WHERE id = ?");
    $stmt->bind_param("i", $livroId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'ID não fornecido']);
}

$conn->close();
?>
