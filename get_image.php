<?php
header("Content-Type: image/jpeg");
include 'database_connection.php';

if (isset($_GET['id'])) {
    $userId = intval($_GET['id']);

    $sql = "SELECT imagem_perfil FROM registrar_usuarios WHERE id = $userId";
    $result = $connection->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['imagem_perfil'];  // Exibe a imagem diretamente
    } else {
        http_response_code(404);
        echo "Imagem não encontrada.";
    }
} else {
    http_response_code(400);
    echo "ID do usuário não fornecido.";
}
?>
