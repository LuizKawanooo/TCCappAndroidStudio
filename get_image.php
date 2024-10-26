<?php
include 'database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $rm = $_GET['rm'];
    $query = "SELECT imagem_perfil FROM registrar_usuarios WHERE rm = '$rm'";
    $result = $connection->query($query);
    $row = $result->fetch_assoc();

    if ($row) {
        $imageData = base64_encode($row['imagem_status']);
        echo json_encode(['success' => true, 'image' => 'data:image/jpeg;base64,' . $imageData]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Imagem não encontrada.']);
    }
}
?>
