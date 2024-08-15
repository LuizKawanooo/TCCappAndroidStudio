<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


// Conexão com o banco de dados
$conn = new mysqli('tccappionic-bd.mysql.uhserver.com', 'ionic_perfil_bd', '{[UOLluiz2019', 'tccappionic_bd');

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Query para buscar artigos
$sql = "SELECT id, titulo, descricao, pdf_nome, data_publicacao FROM artigos";
$result = $conn->query($sql);

$artigos = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $artigos[] = $row;
    }
}

echo json_encode($artigos);

$conn->close();
?>
