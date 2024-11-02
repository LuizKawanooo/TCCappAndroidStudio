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
            // Lógica de upload
        } else {
            // Mostre o erro correspondente
            switch ($_FILES['image']['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    echo json_encode(['success' => false, 'message' => 'O arquivo é muito grande.']);
                    break;
                case UPLOAD_ERR_PARTIAL:
                    echo json_encode(['success' => false, 'message' => 'O arquivo foi apenas parcialmente enviado.']);
                    break;
                case UPLOAD_ERR_NO_FILE:
                    echo json_encode(['success' => false, 'message' => 'Nenhum arquivo foi enviado.']);
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    echo json_encode(['success' => false, 'message' => 'Faltando diretório temporário.']);
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    echo json_encode(['success' => false, 'message' => 'Falha ao escrever o arquivo no disco.']);
                    break;
                case UPLOAD_ERR_EXTENSION:
                    echo json_encode(['success' => false, 'message' => 'Uma extensão do PHP interrompeu o upload.']);
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
