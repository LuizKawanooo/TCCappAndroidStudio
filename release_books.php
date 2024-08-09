<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Aguarda 30 segundos antes de liberar os livros
sleep(30);

// Libera todos os livros que estão alugados
$sql = "UPDATE livros SET status_livros = 0 WHERE status_livros = 1";
$conn->query($sql);

$conn->close();
?>
