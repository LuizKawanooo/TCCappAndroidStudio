<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['error' => 'Erro na conexão: ' . $conn->connect_error]);
    exit;
}

$id = isset($_GET['id']) ? $_GET['id'] : null;
if ($id === null) {
    echo json_encode(['error' => 'ID não fornecido.']);
    exit;
}

$sql = "SELECT * FROM livros WHERE id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['error' => 'Erro na preparação da consulta: ' . $conn->error]);
    exit;
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $livro = $result->fetch_assoc();
    if (isset($livro['imagem']) && !empty($livro['imagem'])) {
        $livro['imagem'] = 'data:image/jpeg;base64,' . base64_encode($livro['imagem']);
    } else {
        $livro['imagem'] = null; // ou uma string padrão se a imagem não existir
    }
    echo json_encode($livro);
} else {
    echo json_encode(['error' => 'Livro não encontrado.']);
}

$stmt->close();
$conn->close();
?>
