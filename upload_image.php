<?php
include 'database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rm = $_POST['rm']; // RM do usuário
    $image = $_FILES['image'];

    if (isset($image) && $image['error'] == 0) {
        $imageData = addslashes(file_get_contents($image['tmp_name']));
        $query = "UPDATE registrar_usuarios SET imagem_perfil = '$imageData' WHERE rm = '$rm'";

        if ($connection->query($query) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Imagem atualizada com sucesso.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar a imagem.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Nenhuma imagem foi enviada.']);
    }
}
?>
