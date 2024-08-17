<?php
header('Content-Type: application/pdf');
header('Access-Control-Allow-Origin: *'); // Permitir acesso de qualquer origem

// Configurações do banco de dados
$servername = "localhost";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$pdfId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Verifica se o ID do PDF é válido
if ($pdfId <= 0) {
    http_response_code(400);
    echo json_encode(array('error' => 'ID inválido'));
    exit;
}

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT arquivo FROM artigos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $pdfId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $fileData = $row['arquivo'];

    // Define o tipo de conteúdo
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="document.pdf"');
    echo base64_decode($fileData); // Decodifica o arquivo PDF armazenado como base64
} else {
    http_response_code(404);
    echo json_encode(array('error' => 'PDF não encontrado'));
}

$stmt->close();
$conn->close();
?>
