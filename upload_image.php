<?php

// Permitir qualquer origem e métodos necessários
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Inclui a conexão com o banco de dados
include 'database_connection.php'; // Certifique-se de que a conexão está configurada corretamente

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se o upload foi feito através de $_FILES
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $rm = $_POST['rm']; // Recebe o RM enviado no formulário

        if (isset($rm)) {
            // Lê o conteúdo da imagem
            $imageData = file_get_contents($_FILES['image']['tmp_name']);

            // Verifica se a imagem foi lida corretamente
            if ($imageData === false) {
                echo json_encode(['success' => false, 'message' => 'Erro ao ler a imagem.']);
                exit;
            }

            // Verifica se o tamanho da imagem é maior que zero
            if (strlen($imageData) === 0) {
                echo json_encode(['success' => false, 'message' => 'Imagem vazia.']);
                exit;
            }

            // Verifica se a imagem é um tipo permitido
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $imageMimeType = mime_content_type($_FILES['image']['tmp_name']);
            if (!in_array($imageMimeType, $allowedMimeTypes)) {
                echo json_encode(['success' => false, 'message' => 'Tipo de imagem não suportado.']);
                exit;
            }

            // Escapa os dados da imagem para evitar injeção SQL
            $imageData = mysqli_real_escape_string($connection, $imageData);

            // Atualiza a imagem de perfil do usuário no banco usando o RM
            $stmt = $connection->prepare("UPDATE registrar_usuarios SET imagem_perfil = ? WHERE rm = ?");
            $stmt->bind_param('ss', $imageData, $rm);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Imagem de perfil atualizada com sucesso.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erro ao atualizar a imagem.']);
            }

            // Fecha a declaração preparada
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'RM não fornecido.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro no upload da imagem.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
}

?>
