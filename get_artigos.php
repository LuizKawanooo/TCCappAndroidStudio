<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");



$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Conecta ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Executa a consulta SQL
$sql = "SELECT id, titulo, descricao, pdf_nome, arquivo FROM artigos";
$result = $conn->query($sql);

$artigos = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $artigos[] = $row;
    }
}

// Define o cabeçalho como JSON
header('Content-Type: application/json');

// Retorna os dados em formato JSON
echo json_encode(array('artigos' => $artigos));

// Fecha a conexão
$conn->close();
?>
