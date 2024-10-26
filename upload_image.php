<?php

// Permitir qualquer origem
header("Access-Control-Allow-Origin: *");

// Permitir os métodos que você deseja
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

// Permitir cabeçalhos personalizados, caso você precise
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");



include 'database_connection.php'; // Certifique-se de que a conexão está configurada corretamente

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $image = $_FILES['image'];

    if (isset($image) && $image['error'] === UPLOAD_ERR_OK) {
        $imageData = addslashes(file_get_contents($image['tmp_name']));
        
        // Aqui, você deve ter uma maneira de identificar o usuário, como um token de sessão ou ID
        $userId = 1; // Mude isso para o ID do usuário logado conforme sua lógica

        // Atualiza a imagem de perfil do usuário
        $sql = "UPDATE registrar_usuarios SET imagem_perfil = '$imageData' WHERE id = $userId";

        if ($connection->query($sql) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Imagem de perfil atualizada com sucesso.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar a imagem.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro no upload da imagem.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
}
?>
