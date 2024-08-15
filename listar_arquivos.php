<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Configurações do banco de dados
$dbHost = 'tccappionic-bd.mysql.uhserver.com';
$dbUser = 'ionic_perfil_bd';
$dbPass = '{[UOLluiz2019';
$dbName = 'tccappionic_bd';

// Conexão com o banco de dados
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Recebe o ID do artigo via GET
$artigoId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Consulta ao banco de dados
$sql = "SELECT titulo, descricao, pdf_nome, arquivo, data_publicacao FROM artigos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $artigoId);
$stmt->execute();
$result = $stmt->get_result();

// Retorna o artigo em formato JSON
if ($result->num_rows > 0) {
    $artigo = $result->fetch_assoc();
    echo json_encode($artigo);
} else {
    echo json_encode(array('message' => 'Artigo não encontrado.'));
}

// Fecha a conexão
$stmt->close();
$conn->close();
?>
