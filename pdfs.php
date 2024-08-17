<?php
// Permite solicitações de qualquer origem
header("Access-Control-Allow-Origin: *");

// Permite os métodos HTTP que podem ser usados na solicitação
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

// Permite os cabeçalhos que podem ser usados na solicitação
header("Access-Control-Allow-Headers: Content-Type, Authorization");

header("Content-Type: application/json; charset=UTF-8");

// Configurações do banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Cria conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta para obter os PDFs
$sql = "SELECT id, titulo FROM artigos";
$result = $conn->query($sql);

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
