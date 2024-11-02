<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

include 'database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image']) && isset($_POST['rm'])) {
        $rm = $_POST['rm'];
        $image = $_FILES['image'];

        if ($image['error'] === UPLOAD_ERR_OK) {
            // Reduz a qualidade da imagem para 70%
            $imageData = file_get_contents($image['tmp_name']);
            $imageResource = imagecreatefromstring($imageData);
            ob_start();
            imagejpeg($imageResource, null, 70); // Salva com 70% de qualidade
            $imageData = ob_get_contents();
            ob_end_clean();

            // Armazena a imagem no banco de dados
            $stmt = $connection->prepare("UPDATE registrar_usuarios SET imagem_perfil = ? WHERE rm = ?");
            $stmt->bind_param('bs', $imageData, $rm);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Imagem enviada com sucesso.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erro ao salvar a imagem no banco de dados.']);
            }

            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro no upload da imagem.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Dados não fornecidos.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
}
?>
