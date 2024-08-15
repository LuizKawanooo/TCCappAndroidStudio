<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Conectar ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    echo json_encode(['error' => 'Conexão falhou: ' . $conn->connect_error]);
    exit;
}

// Verificar se o parâmetro ID foi fornecido
if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'ID do PDF não fornecido.']);
    exit;
}

$id = intval($_GET['id']); // Sanitize input

// Preparar e executar a consulta SQL
$sql = "SELECT pdf_nome, arquivo FROM artigos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Verificar se o PDF foi encontrado
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Definir os cabeçalhos para download do PDF
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="' . $row['pdf_nome'] . '"');
    header('Content-Length: ' . strlen($row['arquivo']));
    
    // Enviar o conteúdo do PDF
    echo $row['arquivo'];
} else {
    echo json_encode(['error' => 'Nenhum PDF encontrado com o ID fornecido.']);
}

// Fechar a conexão
$stmt->close();
$conn->close();
?>
