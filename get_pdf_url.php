<?php


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");



// Conexão com o banco de dados
$conn = new mysqli('tccappionic-bd.mysql.uhserver.com', 'ionic_perfil_bd', '{[UOLluiz2019', 'tccappionic_bd');

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Pegar o ID do artigo
$artigo_id = $_GET['id'];

// Query para buscar o arquivo PDF
$sql = "SELECT arquivo FROM artigos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $artigo_id);
$stmt->execute();
$stmt->bind_result($arquivo);
$stmt->fetch();

if ($arquivo) {
    echo json_encode(array('pdf_url' => 'https://endologic.com.br/tcc/' . $arquivo));
} else {
    echo json_encode(array('error' => 'Arquivo não encontrado.'));
}

$stmt->close();
$conn->close();
?>
