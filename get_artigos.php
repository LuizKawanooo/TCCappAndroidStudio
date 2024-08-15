<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta para obter todos os artigos
$sql = "SELECT id, titulo, descricao, pdf_nome FROM artigos";
$result = $conn->query($sql);

$artigos = [];
if ($result->num_rows > 0) {
    // Preenche o array com os resultados
    while ($row = $result->fetch_assoc()) {
        $artigos[] = $row;
    }
} else {
    echo json_encode(["artigos" => []]);
    exit();
}

echo json_encode(["artigos" => $artigos]);

$conn->close();
?>
