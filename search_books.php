<?php
header('Content-Type: application/json');
require 'db_connection.php'; // Ajuste o caminho conforme necessário

$searchTerm = isset($_GET['q']) ? '%' . $_GET['q'] . '%' : '%';

// Prepara e executa a consulta SQL
$sql = "SELECT `id`, `titulo` AS `title`, `genero`, `autor` AS `author`, `editora`, `tombo`, `ano`, `classificacao`, `n_paginas`, `isbn`, `sinopse`, `image_url`, `status_livros`
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
