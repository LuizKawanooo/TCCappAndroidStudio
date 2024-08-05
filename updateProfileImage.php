<?php

// Configurações de CORS
header("Access-Control-Allow-Origin: *"); // Permite todas as origens. Substitua '*' pelo domínio específico se necessário.
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Métodos permitidos
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Cabeçalhos permitidos

// Configuração do banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtém dados do POST
$rm = $_POST['rm'];
$image = $_POST['image'];

// Verifica se os dados foram recebidos
if (empty($rm) || empty($image)) {
    echo json_encode(['success' => false, 'message' => 'RM ou imagem não fornecidos']);
    exit;
}

// Converte o base64 em binário
$imageData = base64_decode($image);

// Atualiza a imagem no banco de dados
$stmt = $conn->prepare("UPDATE registrar_usuarios SET imagem_perfil = ? WHERE rm = ?");
$stmt->bind_param('sb', $imageData, $rm);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Falha ao atualizar imagem de perfil']);
}

$stmt->close();
$conn->close();
?>


