<?php

// Permitir qualquer origem e métodos necessários
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

include 'database_connection.php'; // Certifique-se de que a conexão está configurada corretamente

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rm = isset($_POST['rm']) ? $_POST['rm'] : null;
    $image = isset($_FILES['image']) ? $_FILES['image'] : null;

    // Verifica se a imagem e o RM foram enviados e se não houve erros no upload
    if ($image && $image['error'] === UPLOAD_ERR_OK && $rm) {
        // Validação do tipo de arquivo (somente imagens)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($image['type'], $allowedTypes)) {
            echo json_encode(['success' => false, 'message' => 'Formato de imagem não suportado.']);
            exit;
        }

        // Lê e processa o conteúdo da imagem
        $imageData = file_get_contents($image['tmp_name']);

        // Prepared statement para segurança
        $stmt = $connection->prepare("UPDATE registrar_usuarios SET imagem_perfil = ? WHERE rm = ?");
        $stmt->bind_param('ss', $imageData, $rm);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Imagem de perfil atualizada com sucesso.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar a imagem.']);
        }
        
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro no upload da imagem ou RM não fornecido.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
}

$connection->close();
?>
