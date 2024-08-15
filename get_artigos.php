<?php
// Habilitar exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Conectar ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Conexão falhou: ' . $conn->connect_error]));
} else {
    // Mensagem de depuração
    // echo 'Conexão bem-sucedida';
}

$sql = "SELECT id, titulo, descricao, pdf_nome FROM artigos";
$result = $conn->query($sql);

if (!$result) {
    die(json_encode(['error' => 'Erro na consulta SQL: ' . $conn->error]));
}

$artigos = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $artigos[] = $row;
    }
} else {
    // Mensagem de depuração
    // echo 'Nenhum artigo encontrado';
}

echo json_encode(['artigos' => $artigos]);

$conn->close();
?>
