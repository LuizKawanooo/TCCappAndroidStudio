<?php

// Permitir qualquer origem e métodos necessários
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

include 'database_connection.php'; // Certifique-se de que a conexão está configurada corretamente

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $image = $_FILES['image'];
    $userId = $_POST['user_id']; // Recebe o ID do usuário enviado no formulário

    if (isset($image) && $image['error'] === UPLOAD_ERR_OK && isset($userId)) {
        // Lê o conteúdo da imagem e prepara para inserção no banco de dados
        $imageData = addslashes(file_get_contents($image['tmp_name']));
        
        // Atualiza a imagem de perfil do usuário no banco
        $sql = "UPDATE registrar_usuarios SET imagem_perfil = '$imageData' WHERE id = $userId";
        
        if ($connection->query($sql) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Imagem de perfil atualizada com sucesso.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar a imagem.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro no upload da imagem ou ID do usuário não fornecido.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
}

?>
