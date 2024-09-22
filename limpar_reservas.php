<?php
include 'db.php'; // Incluindo a conexão ao banco de dados

function limparReservasAntigas($conn) {
    $sql = "DELETE FROM reservas_computadores WHERE created_at < NOW() - INTERVAL 30 SECOND";
    if ($conn->query($sql) === TRUE) {
        return json_encode(['success' => true, 'message' => 'Reservas antigas removidas com sucesso.']);
    } else {
        return json_encode(['success' => false, 'message' => 'Erro ao limpar reservas: ' . $conn->error]);
    }
}

header('Content-Type: application/json');
echo limparReservasAntigas($conn);
?>
