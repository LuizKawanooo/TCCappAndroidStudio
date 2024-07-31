<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$host = 'localhost';
$db = 'seu_banco_de_dados';
$user = 'seu_usuario';
$pass = 'sua_senha';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('Erro de conexão: ' . $conn->connect_error);
}

// Obtém o ID do livro da query string
$id = intval($_GET['id']);

$sql = "SELECT * FROM livro WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $livro = $result->fetch_assoc();
    $livro['imagem_url'] = 'http://sua-api-url/imagem.php?id=' . $id;
    $livro['pdf_url'] = 'http://sua-api-url/pdf.php?id=' . $id;
    echo json_encode($livro);
} else {
    echo json_encode(array());
}

$stmt->close();
$conn->close();
?>
