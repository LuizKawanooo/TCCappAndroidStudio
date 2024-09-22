<?php
// Configurações de cabeçalhos CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Content-Type: application/json');

// Conexão com o banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Consulta SQL para recuperar os artigos
$sql = "SELECT id, titulo, autor, ano FROM artigos";
$result = $conn->query($sql);

$artigos = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $artigos[] = $row;
    }
}

$conn->close();
echo json_encode($artigos);
?>
