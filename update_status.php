<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id']) && isset($data['status'])) {
    $id = intval($data['id']);
    $status = intval($data['status']);
    
    $sql = "UPDATE livros SET status_livros = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $status, $id);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Status atualizado com sucesso']);
    } else {
        echo json_encode(['message' => 'Erro ao atualizar o status']);
    }
} else {
    echo json_encode(['message' => 'Dados inválidos']);
}

$stmt->close();
$conn->close();
?>
