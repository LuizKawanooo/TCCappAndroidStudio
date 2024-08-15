<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT id, titulo, descricao, pdf_nome, arquivo FROM artigos";
$result = $conn->query($sql);

$artigos = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $artigos[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode(array('artigos' => $artigos));

$conn->close();
?>

