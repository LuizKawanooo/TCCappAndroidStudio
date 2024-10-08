<?php

header("Access-Control-Allow-Origin: *"); // Permitir todas as origens
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Métodos permitidos
header("Access-Control-Allow-Headers: Content-Type"); // Cabeçalhos permitidos

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Conectar ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$searchTerm = isset($_GET['q']) ? '%' . $_GET['q'] . '%' : '%';

// Preparar a consulta
$sql = "SELECT `id`, `titulo`, `genero`, `autor`, `editora`, `tombo`, `ano`, `classificacao`, `n_paginas`, `isbn`, `sinopse`, `status_livros`, `imagem`
        FROM livros 
        WHERE `titulo` LIKE ? OR `autor` LIKE ?";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Erro na preparação da consulta: " . $conn->error);
}

// Bind dos parâmetros
$stmt->bind_param('ss', $searchTerm, $searchTerm);

// Executar a consulta
$stmt->execute();

// Obter resultados
$result = $stmt->get_result();

$books = array();
while ($row = $result->fetch_assoc()) {
    // Supondo que 'imagem' é o caminho para o arquivo .bin
    // Você pode precisar ajustar isso para corresponder ao seu formato real
    $row['imagem'] = '/path/to/images/' . $row['imagem']; // Ajuste o caminho para onde as imagens estão armazenadas
    $books[] = $row;
}

// Retornar resultados como JSON
header('Content-Type: application/json');
echo json_encode($books);

// Fechar a conexão
$stmt->close();
$conn->close();
?>
