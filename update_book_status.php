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

// Recebe o ID e o novo status do livro do frontend
$input = json_decode(file_get_contents('php://input'), true);
$id = $input['id'];
$status = $input['status'];

// Atualiza o status do livro
$sql = "UPDATE livros SET status_livros = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $status, $id);

if ($stmt->execute()) {
    echo json_encode(array("message" => "Status updated successfully"));
} else {
    echo json_encode(array("message" => "Failed to update status"));
}

$stmt->close();
$conn->close();
?>
