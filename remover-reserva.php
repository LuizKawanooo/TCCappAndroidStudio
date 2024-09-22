<?php

require 'config.php';

// Inclua suas definições de conexão com o banco de dados aqui

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Erro de conexão: ' . $conn->connect_error]);
        exit;
    }

    $data = json_decode(file_get_contents('php://input'), true);
    $computadorId = $data['computador_id'];
    $horario = $data['horario'];

    $query = "DELETE FROM reservas_computadores WHERE computador_id = ? AND horario = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $computadorId, $horario);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao remover a reserva.']);
    }

    $stmt->close();
    $conn->close();
}
?>
