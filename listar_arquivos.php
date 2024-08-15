<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Configurações do banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Criar conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    echo json_encode(array("error" => "Conexão falhou: " . $conn->connect_error));
    exit();
}

// Preparar a consulta SQL
$sql = "SELECT id, titulo, descricao, pdf_nome FROM artigos";

// Executar a consulta
$result = $conn->query($sql);

// Verificar se a consulta foi bem-sucedida
if ($result === false) {
    echo json_encode(array("error" => "Erro na consulta: " . $conn->error));
    exit();
}

$artigos = array();

// Verificar se há resultados
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $artigos[] = $row;
    }
    echo json_encode(array("artigos" => $artigos));
} else {
    echo json_encode(array("artigos" => []));
}

// Liberar o resultado e fechar a conexão
$result->free();
$conn->close();
?>
