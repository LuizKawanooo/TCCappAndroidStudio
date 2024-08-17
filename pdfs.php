<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permitir acesso de qualquer origem

// Configurações do banco de dados
$servername = "localhost";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, titulo FROM artigos"; // Ajuste a tabela e colunas conforme sua estrutura
$result = $conn->query($sql);

$pdfs = array();
while ($row = $result->fetch_assoc()) {
    $pdfs[] = $row;
}

echo json_encode($pdfs);

$conn->close();
?>
