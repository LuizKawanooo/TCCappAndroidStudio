<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Criar a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão com o banco de dados
if ($conn->connect_error) {
    die(json_encode(array("error" => "Falha na conexão com o banco de dados: " . $conn->connect_error)));
}

// Preparar a consulta SQL
$sql = "SELECT id, titulo, descricao, pdf_nome FROM artigos";

// Executar a consulta
$result = $conn->query($sql);

// Verificar se a consulta foi bem-sucedida
if ($result === false) {
    die(json_encode(array("error" => "Falha na consulta SQL: " . $conn->error)));
}

$artigos = array();

// Verificar se há resultados
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $artigos[] = $row;
    }
    echo json_encode(array("artigos" => $artigos));
} else {
    echo json_encode(array("artigos" => []));
}

$result->free();
$conn->close();
?>
