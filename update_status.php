<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);
$bookId = $data['id'];

if ($data['status'] == 1) {
    // Alugando o livro
    $sql = "UPDATE livros SET status_livros = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookId);
    $stmt->execute();

    // Timer para devolver o livro
    sleep(30);

    // Devolver o livro após 30 segundos
    $sql = "UPDATE livros SET status_livros = 0 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    
    echo json_encode(array("message" => "Book rented and returned after 30 seconds"));
} else {
    echo json_encode(array("message" => "Invalid status"));
}

$conn->close();
?>
