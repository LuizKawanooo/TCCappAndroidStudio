<?php
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

$sql = "SELECT imagem FROM livro WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($imagem);
$stmt->fetch();

if ($imagem) {
    header('Content-Type: image/jpeg'); // Ajuste conforme o tipo de imagem, pode ser image/png, etc.
    echo $imagem;
} else {
    http_response_code(404);
}

$stmt->close();
$conn->close();
?>
