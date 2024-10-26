<?php

// Permitir qualquer origem
header("Access-Control-Allow-Origin: *");

// Conectar ao banco de dados
include 'database_connection.php'; // Verifique se a conexão está correta

if (isset($_GET['id'])) {
    $userId = intval($_GET['id']); // Obtenha o ID do usuário da URL

    // Preparar a consulta para obter a imagem
    $sql = "SELECT imagem_perfil FROM registrar_usuarios WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($imagem_perfil);
        $stmt->fetch();

        // Definir os cabeçalhos corretos
        header("Content-Type: image/jpeg"); // ou o tipo correto da imagem
        echo $imagem_perfil; // Enviar a imagem
    } else {
        echo json_encode(['success' => false, 'message' => 'Usuário não encontrado.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID do usuário não fornecido.']);
}

$stmt->close();
$connection->close();
?>
