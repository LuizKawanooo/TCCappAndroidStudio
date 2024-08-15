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
$params = [];
$conditions = [];

// Adicionar condição de filtro por título, se fornecido
if (isset($_GET['title'])) {
    $title = $conn->real_escape_string($_GET['title']);
    $conditions[] = "titulo LIKE ?";
    $params[] = '%' . $title . '%';
}

// Adicionar condições à consulta SQL
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$sql .= " ORDER BY id"; // Ordenar os resultados por ID

// Preparar e executar a consulta
$stmt = $conn->prepare($sql);

// Verificar se a preparação da consulta foi bem-sucedida
if ($stmt === false) {
    die(json_encode(array("error" => "Falha ao preparar a consulta: " . $conn->error)));
}

// Vincular parâmetros, se houver
if (!empty($params)) {
    $types = str_repeat('s', count($params)); // Tipo dos parâmetros
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$artigos = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $artigos[] = array(
            "id" => $row["id"],
            "titulo" => $row["titulo"],
            "descricao" => $row["descricao"],
            "pdf_nome" => $row["pdf_nome"]
        );
    }
    echo json_encode(array("artigos" => $artigos));
} else {
    echo json_encode(array("artigos" => []));
}

$stmt->close();
$conn->close();
?>
