<?php

// Permitir qualquer origem e métodos necessários
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

include 'database_connection.php'; // Certifique-se de que a conexão está configurada corretamente

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $image = $_FILES['image'];
    $rm = $_POST['rm']; // Recebe o RM enviado no formulário

    if (isset($image) && $image['error'] === UPLOAD_ERR_OK && isset($rm)) {
        // Lê o conteúdo da imagem
        $imageData = file_get_contents($image['tmp_name']);
        
        // Escapa os dados da imagem para evitar injeção SQL
        $imageData = mysqli_real_escape_string($connection, $imageData);

        // Atualiza a imagem de perfil do usuário no banco usando o RM
        $sql = "UPDATE registrar_usuarios SET imagem_perfil = '$imageData' WHERE rm = '$rm'";
        
        if ($connection->query($sql) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Imagem de perfil atualizada com sucesso.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar a imagem.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro no upload da imagem ou RM não fornecido.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
}

?>
