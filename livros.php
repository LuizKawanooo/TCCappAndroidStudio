<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT titulo, genero, autor, editora, tombo, ano, classificacao, n_paginas, isbn, imagem FROM livros";
$result = $conn->query($sql);

$livros = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $livros[] = $row;
    }
}

$conn->close();

echo json_encode($livros);
?>
