<?php
include 'db.php'; // Incluindo a conexão ao banco de dados

function limparReservasAntigas($conn) {
    $timestampLimite = date('Y-m-d H:i:s', strtotime('-30 seconds'));
    $sql = "DELETE FROM reservas WHERE horario < ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $timestampLimite);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        return json_encode(['success' => true, 'message' => 'Reservas limpas com sucesso.']);
    } else {
        return json_encode(['success' => false, 'message' => 'Nenhuma reserva antiga encontrada.']);
    }
}

header('Content-Type: application/json');
echo limparReservasAntigas($conn);
?>
