<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "seu_usuario";
$password = "sua_senha";
$dbname = "nome_do_banco";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $videoId = $_POST['videoId'];
    $title = $_POST['title'];

    $stmt = $conn->prepare("INSERT INTO queue (video_id, title) VALUES (?, ?)");
    $stmt->bind_param("ss", $videoId, $title);

    if ($stmt->execute()) {
        echo "Música adicionada à fila com sucesso!";
    } else {
        echo "Erro ao adicionar música à fila.";
    }

    $stmt->close();
}

$conn->close();
?>
