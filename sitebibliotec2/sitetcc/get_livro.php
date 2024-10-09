<?php
header('Content-Type: text/html; charset=utf-8'); // Define o tipo de conteúdo

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? $_GET['id'] : null;
if ($id === null) {
    die("ID não fornecido.");
}

// Prepara a consulta para selecionar os dados do livro
$sql = "SELECT * FROM livros WHERE id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Erro na preparação da consulta: " . $conn->error);
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $livro = $result->fetch_assoc();
    echo "<h1>Detalhes do Livro</h1>";
    echo "<p><strong>ID:</strong> " . htmlspecialchars($livro['id']) . "</p>";
    echo "<p><strong>Título:</strong> " . htmlspecialchars($livro['titulo']) . "</p>";
    echo "<p><strong>Autor:</strong> " . htmlspecialchars($livro['autor']) . "</p>";
    echo "<p><strong>Editora:</strong> " . htmlspecialchars($livro['editora']) . "</p>";
    echo "<p><strong>Gênero:</strong> " . htmlspecialchars($livro['genero']) . "</p>";
    echo "<p><strong>Tombo:</strong> " . htmlspecialchars($livro['tombo']) . "</p>";
    echo "<p><strong>Ano:</strong> " . htmlspecialchars($livro['ano']) . "</p>";
    echo "<p><strong>Classificação:</strong> " . htmlspecialchars($livro['classificacao']) . "</p>";
    echo "<p><strong>Número de Páginas:</strong> " . htmlspecialchars($livro['n_paginas']) . "</p>";
    echo "<p><strong>ISBN:</strong> " . htmlspecialchars($livro['isbn']) . "</p>";
} else {
    echo "<p>Livro não encontrado.</p>";
}

$stmt->close();
$conn->close();
?>
