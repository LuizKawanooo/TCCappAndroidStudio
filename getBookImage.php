<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(array("error" => "Erro de conexão: " . $conn->connect_error)));
}

$bookId = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT imagem FROM livros WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $bookId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(array("image_url" => 'data:image/jpeg;base64,' . base64_encode($row["imagem"])));
} else {
    echo json_encode(array("error" => "Imagem não encontrada"));
}

$stmt->close();
$conn->close();
