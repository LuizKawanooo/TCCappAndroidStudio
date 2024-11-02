<?php

// Permitir qualquer origem e métodos necessários
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Inclui a conexão com o banco de dados
include 'database_connection.php'; // Certifique-se de que a conexão está configurada corretamente

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se o upload foi feito através de $_FILES
    if (isset($_FILES['image'])) {
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Lê o conteúdo do arquivo
            $imageData = file_get_contents($_FILES['image']['tmp_name']);
            $imageName = basename($_FILES['image']['name']);
            
            // Recebe o RM do usuário enviado no formulário
            $rm = $_POST['rm']; // Certifique-se de que 'rm' é enviado no formulário

            // Prepara a consulta para atualizar a imagem de perfil no banco de dados
            $stmt = $connection->prepare("UPDATE registrar_usuarios SET imagem_perfil = ? WHERE rm = ?");
            $stmt->bind_param('bs', $imageData, $rm); // 'b' para o LONGBLOB e 's' para string

            if ($stmt->execute()) {
                // Imagem salva com sucesso no banco de dados
                echo json_encode(['success' => true, 'message' => 'Imagem de perfil atualizada com sucesso.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Falha ao atualizar a imagem de perfil no banco de dados.']);
            }

            // Fecha a declaração preparada
            $stmt->close();
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
        echo json_encode(['success' => false, 'message' => 'Nenhum arquivo enviado.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
}

?>
