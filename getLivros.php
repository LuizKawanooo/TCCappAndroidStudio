<?php
header("Content-Type: application/json");

// Conectar ao banco de dados
$host = "localhost";
$dbname = "seu_banco_de_dados";
$username = "seu_usuario";
$password = "sua_senha";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Preparar a consulta
    $stmt = $pdo->prepare("SELECT titulo, genero, autor, editora, tombo, ano, classificacao, n_paginas, isbn, imagem FROM livros");
    $stmt->execute();

    // Buscar todos os livros
    $livros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retornar os dados como JSON
    echo json_encode($livros);

} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
