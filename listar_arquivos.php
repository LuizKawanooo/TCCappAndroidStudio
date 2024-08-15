<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Criar a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão com o banco de dados
if ($conn->connect_error) {
    die(json_encode(array("error" => "Falha na conexão com o banco de dados: " . $conn->connect_error)));
}

// Preparar a consulta SQL
$sql = "SELECT id, titulo, descricao, pdf_nome FROM artigos";




$sql .= " ORDER BY id"; // Ordenar os resultados por ID (ou outro critério que desejar)

// Preparar e executar a consulta
$stmt = $conn->prepare($sql);

// Verificar se a preparação da consulta foi bem-sucedida
if ($stmt === false) {
    die(json_encode(array("error" => "Falha ao preparar a consulta: " . $conn->error)));
}

$stmt->execute();
$result = $stmt->get_result();

$arquivos = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $arquivos[] = array(
            "id" => $row["id"],
            "arquivo" => 'data:image/jpeg;base64,' . base64_encode($row["imagem"]),
        );
    }
    echo json_encode(array("arquivo" => $arquivos));
} else {
    echo json_encode(array("arquivo" => []));
}

$stmt->close();
$conn->close();
?>
