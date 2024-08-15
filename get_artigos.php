<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON


$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Criar a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta para buscar artigos
$sql = "SELECT id, titulo, descricao, pdf_nome FROM artigos";
$result = $conn->query($sql);

// Inicializar um array para armazenar os artigos
$artigos = [];

if ($result->num_rows > 0) {
    // Busca cada linha e armazena no array
    while($row = $result->fetch_assoc()) {
        $artigos[] = $row;
    }
}

// Fechar a conexão
$conn->close();

// Enviar a resposta JSON
echo json_encode(['artigos' => $artigos]);
?>

