<?php
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta SQL para contar os artigos
$sql = "SELECT COUNT(*) as count FROM artigos";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

echo json_encode(['count' => $row['count']]);

$conn->close();
?>
