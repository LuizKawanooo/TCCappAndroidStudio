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
        // Recebe o RM enviado no formulário
        $rm = $_POST['rm']; 

        if (isset($rm)) {
            // Lê o conteúdo da imagem
            $imageData = file_get_contents($_FILES['image']['tmp_name']);
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
    } elseif (isset($_POST['image'])) {
        // Lógica para quando a imagem é enviada em formato Base64
        $rm = isset($_POST['rm']) ? $_POST['rm'] : null;
        $base64Image = isset($_POST['image']) ? $_POST['image'] : null;

        // Diagnóstico: verifica se o RM foi recebido
        if (!$rm) {
            echo json_encode(['success' => false, 'message' => 'RM não recebido pelo servidor.']);
            exit;
        }

        // Diagnóstico: verifica se a imagem foi recebida
        if (!$base64Image) {
            echo json_encode(['success' => false, 'message' => 'Imagem não recebida pelo servidor.']);
            exit;
        }

        // Remove o prefixo "data:image/*;base64," do Base64, se presente
        $base64Image = preg_replace('#^data:image/\w+;base64,#i', '', $base64Image);

        // Decodifica a imagem de Base64 para binário
        $imageData = base64_decode($base64Image);

        // Verifica se a decodificação foi bem-sucedida
        if ($imageData === false) {
            echo json_encode(['success' => false, 'message' => 'Erro ao decodificar a imagem.']);
            exit;
        }

        // Escapa os dados da imagem para evitar injeção SQL
        $imageData = mysqli_real_escape_string($connection, $imageData);

        // Atualiza a imagem de perfil do usuário no banco usando o RM
        $stmt = $connection->prepare("UPDATE registrar_usuarios SET imagem_perfil = ? WHERE rm = ?");
        $stmt->bind_param('ss', $imageData, $rm);

        // Executa a declaração SQL e verifica o sucesso
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Imagem de perfil atualizada com sucesso.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar a imagem.']);
        }

        // Fecha a declaração preparada
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro no upload da imagem ou RM não fornecido.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
}

?>
