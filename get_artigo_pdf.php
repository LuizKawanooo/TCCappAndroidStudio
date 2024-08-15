<?php
header('Content-Type: application/pdf');

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Criar a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se o ID foi fornecido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    http_response_code(400);
    echo "ID não fornecido.";
    exit;
}

$id = intval($_GET['id']);

// Consulta para buscar o PDF do artigo
$sql = "SELECT pdf_nome, arquivo FROM artigos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($pdf_nome, $arquivo);
$stmt->fetch();

// Verificar se o artigo foi encontrado
if (!$pdf_nome || !$arquivo) {
    http_response_code(404);
    echo "Artigo não encontrado.";
    exit;
}

// Fechar a conexão
$stmt->close();
$conn->close();

// Configurar o nome do arquivo PDF no cabeçalho
header("Content-Disposition: inline; filename=\"$pdf_nome\"");
echo $arquivo;
?>
