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

// Verificar se o parâmetro 'genre', 'search' ou 'title' foi fornecido
$genre = isset($_GET['genre']) ? $conn->real_escape_string($_GET['genre']) : '';
$searchTerm = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$title = isset($_GET['title']) ? $conn->real_escape_string($_GET['title']) : '';

// Preparar a consulta SQL
$sql = "SELECT id, imagem, status_livros FROM livros";
$params = [];
$conditions = [];

// Adicionar a condição de filtro por gênero, se fornecido
if (!empty($genre)) {
    $conditions[] = "genero = ?";
    $params[] = $genre;
}

// Adicionar a condição de filtro por pesquisa, se fornecido
if (!empty($searchTerm)) {
    $conditions[] = "(autor LIKE ? OR titulo LIKE ?)";
    $params[] = '%' . $searchTerm . '%';
    $params[] = '%' . $searchTerm . '%';
}

// Adicionar a condição de filtro por título, se fornecido
if (!empty($title)) {
    $conditions[] = "titulo LIKE ?";
    $params[] = '%' . $title . '%';
}

// Adicionar condições à consulta SQL
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$sql .= " ORDER BY id"; // Ordenar os resultados por ID (ou outro critério que desejar)

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

$images = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $images[] = array(
            "id" => $row["id"],
            "image_url" => 'data:image/jpg;base64,' . base64_encode($row["imagem"]),
            "status_livros" => $row["status_livros"]
        );
    }
    echo json_encode(array("images" => $images));
} else {
    echo json_encode(array("images" => []));
}

$stmt->close();
$conn->close();
?>





