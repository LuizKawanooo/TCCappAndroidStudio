<?php
header("Access-Control-Allow-Origin: *"); // Permite requisições de qualquer origem

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$videoId = $_GET['videoId'];
$title = urldecode($_GET['title']);

$sql = "INSERT INTO queue (video_id, title) VALUES ('$videoId', '$title')";

if ($conn->query($sql) === TRUE) {
    echo "Música adicionada à fila com sucesso.";
} else {
    echo "Erro: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
