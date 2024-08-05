<?php
header('Content-Type: application/json');
require 'db_connection.php'; // Ajuste o caminho conforme necessário

// Verifica se o termo de pesquisa foi fornecido
if (!isset($_GET['q'])) {
    echo json_encode([]);
    exit;
}

$searchTerm = '%' . $_GET['q'] . '%';

// Prepara e executa a consulta SQL
$sql = "SELECT `id`, `titulo` AS `title`, `genero`, `autor` AS `author`, `editora`, `tombo`, `ano`, `classificacao`, `n_paginas`, `isbn`, `sinopse` 
        FROM `livros` 
        WHERE `titulo` LIKE ? OR `autor` LIKE ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $searchTerm, $searchTerm);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $books = [];

    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }

    echo json_encode($books);
} else {
    echo json_encode([]);
}

$stmt->close();
$conn->close();
?>
