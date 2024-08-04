<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the book ID from the query string
$bookId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Query to fetch book details
$sql = "SELECT titulo, genero, autor, editora, tombo, ano, classificacao, n_paginas, isbn FROM livros WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $bookId);
$stmt->execute();
$result = $stmt->get_result();

$book = $result->fetch_assoc();

if ($book) {
    echo json_encode($book);
} else {
    echo json_encode(array("message" => "Book not found"));
}

$stmt->close();
$conn->close();
?>
