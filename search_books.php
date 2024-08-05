<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Cria conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$searchTerm = $_GET['q'];

$sql = "SELECT * FROM livros WHERE titulo LIKE ? OR autor LIKE ?";
$stmt = $conn->prepare($sql);
$likeTerm = "%" . $searchTerm . "%";
$stmt->bind_param("ss", $likeTerm, $likeTerm);
$stmt->execute();

$result = $stmt->get_result();
$books = [];

while ($row = $result->fetch_assoc()) {
    $books[] = $row;
}

echo json_encode($books);

$stmt->close();
$conn->close();
?>
