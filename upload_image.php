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
        $rm = isset($_POST['rm']) ? $_POST['rm'] : null; // Recebe o RM enviado no formulário

        if ($rm) {
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
            echo json_encode(['success' => false, 'message' => 'RM não fornecido.']);
        }
    } else {
        // Mensagens de erro
        switch ($_FILES['image']['error']) {
            case UPLOAD_ERR_NO_FILE:
                echo json_encode(['success' => false, 'message' => 'Nenhum arquivo foi enviado.']);
                break;
            case UPLOAD_ERR_INI_SIZE:
                echo json_encode(['success' => false, 'message' => 'Arquivo muito grande.']);
                break;
            case UPLOAD_ERR_PARTIAL:
                echo json_encode(['success' => false, 'message' => 'Arquivo enviado parcialmente.']);
                break;
            default:
                echo json_encode(['success' => false, 'message' => 'Erro desconhecido no upload.']);
                break;
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
}

?>
