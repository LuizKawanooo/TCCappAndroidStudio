<?php
header("Content-Type: application/json");

// Conectar ao banco de dados
$host = "tccappionic-bd.mysql.uhserver.com";
$dbname = "tccappionic_bd";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Preparar a consulta
    $stmt = $pdo->prepare("SELECT titulo, genero, autor, editora, tombo, ano, classificacao, n_paginas, isbn, imagem FROM livro");
    $stmt->execute();

    // Buscar todos os livros
    $livros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retornar os dados como JSON
    echo json_encode($livros);

} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
