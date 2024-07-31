<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$host = 'tccappionic-bd.mysql.uhserver.com'; // Substitua pelo seu host do banco de dados
$db = 'tccappionic_bd'; // Substitua pelo nome do seu banco de dados
$user = 'ionic_perfil_bd'; // Substitua pelo seu usuário do banco de dados
$pass = '{[UOLluiz2019'; // Substitua pela sua senha do banco de dados

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
    // Adiciona URLs para o PDF
    $livro['pdf_url'] = 'http://sua-api-url/pdf.php?id=' . $id;
    echo json_encode($livro);
} else {
    echo json_encode(array());
}

$stmt->close();
$conn->close();
?>
