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

// Verificar se o parâmetro 'user_id' foi fornecido
$userId = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if ($userId > 0) {
    // Preparar a consulta SQL para obter a imagem de perfil do usuário
    $sql = "SELECT imagem_perfil FROM registrar_usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    // Verificar se a preparação da consulta foi bem-sucedida
    if ($stmt === false) {
        die(json_encode(array("error" => "Falha ao preparar a consulta: " . $conn->error)));
    }

    // Vincular o parâmetro
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Retornar a imagem de perfil em formato base64
        echo json_encode(array(
            "success" => true,
            "image_url" => 'data:image/jpeg;base64,' . base64_encode($row["imagem_perfil"])
        ));
    } else {
        echo json_encode(array("success" => false, "message" => "Usuário não encontrado."));
    }

    $stmt->close();
} else {
    echo json_encode(array("success" => false, "message" => "ID do usuário não fornecido ou inválido."));
}

$conn->close();
?>
