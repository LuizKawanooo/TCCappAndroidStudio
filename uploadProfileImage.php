<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se a imagem foi enviada sem erros
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Informações da imagem
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];
        $imageSize = $_FILES['image']['size'];
        $imageType = $_FILES['image']['type'];

        // Lê o conteúdo da imagem e converte para base64
        $imageData = file_get_contents($imageTmpPath);
        $base64Image = base64_encode($imageData);

        // Conexão com o banco de dados (substitua com suas credenciais)
        $conn = new mysqli('tccappionic-bd.mysql.uhserver.com', 'ionic_perfil_bd', '{[UOLluiz2019', 'tccappionic_bd');

        // Verifica a conexão
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        // ID do usuário (você pode obter este valor via POST ou sessão, por exemplo)
        $userId = $_POST['user_id']; // Certifique-se de que o 'user_id' esteja sendo passado corretamente

        // Armazena a imagem como base64 no banco de dados na tabela "registrar_usuario"
        $sql = "UPDATE registrar_usuario SET imagem_perfil = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $base64Image, $userId); // 'si' = string (imagem) e inteiro (id)

        // Executa a query e verifica o resultado
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Imagem de perfil atualizada com sucesso!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao salvar imagem no banco de dados.']);
        }

        // Fecha a declaração e a conexão
        $stmt->close();
        $conn->close();
    } else {
        // Se houve algum erro no upload
        echo json_encode(['success' => false, 'message' => 'Erro no upload da imagem.']);
    }
}
?>
