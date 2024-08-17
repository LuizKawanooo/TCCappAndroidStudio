<?php
header('Content-Type: application/json');
include 'db_connection.php'; // Inclua seu arquivo de conexão com o banco de dados

// Cria a conexão com o banco de dados
$conn = OpenCon();

$sql = "SELECT id, titulo FROM artigos"; // Ajuste a tabela e colunas conforme sua estrutura
$result = $conn->query($sql);

$pdfs = array();
while ($row = $result->fetch_assoc()) {
    $pdfs[] = $row;
}

echo json_encode($pdfs);

CloseCon($conn);
?>
