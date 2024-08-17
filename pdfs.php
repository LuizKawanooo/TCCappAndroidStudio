<?php
// Habilita exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Permite solicitações de qualquer origem
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

// Configurações do banco de dados
$servername = "localhost"; // Use o hostname do seu servidor MySQL
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Cria conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die(json_encode(array("error" => "Connection failed: " . $conn->connect_error)));
}

// Consulta para obter os PDFs
$sql = "SELECT id, titulo FROM artigos";
$result = $conn->query($sql);

if ($result === false) {
    die(json_encode(array("error" => "Query failed: " . $conn->error)));
}

$pdfs = array();
if ($result->num_rows > 0) {
    // Adiciona cada linha ao array
    while($row = $result->fetch_assoc()) {
        $pdfs[] = $row;
    }
}

// Fecha a conexão
$conn->close();

// Retorna o JSON com os PDFs
echo json_encode($pdfs);
?>
