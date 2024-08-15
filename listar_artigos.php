<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Habilitar exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conectar ao banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die(json_encode(["error" => "Conexão falhou: " . $conn->connect_error]));
}

// Query para listar os artigos
$sql = "SELECT id, titulo, descricao, pdf_nome, data_publicacao FROM artigos";
$result = $conn->query($sql);

$artigos = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $artigos[] = $row;
    }
    echo json_encode($artigos);
} else {
    echo json_encode([]);
}

$conn->close();
?>
