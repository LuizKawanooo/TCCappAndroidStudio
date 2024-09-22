<?php
// processarReservasExpiradas.php

// Definições do banco de dados
define('DB_HOST', 'tccappionic-bd.mysql.uhserver.com'); // Host do banco de dados
define('DB_USER', 'ionic_perfil_bd'); // Usuário do banco de dados
define('DB_PASS', '{[UOLluiz2019'); // Senha do banco de dados
define('DB_NAME', 'tccappionic_bd'); // Nome do banco de dados

// Conexão com o banco de dados
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verifica a conexão
if ($conn->connect_error) {
    error_log("Erro de conexão: " . $conn->connect_error);
    exit;
}

// Seleciona todas as reservas expiradas
$query = "SELECT * FROM reservas_computadores WHERE rental_end_time <= NOW() AND status = 'reservado'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $computadorId = $row['computador_id'];
        $horario = $row['horario'];
        $alunoNome = $row['aluno_nome'];
        $emailContato = $row['email_contato'];
        $dataReserva = $row['data_reserva'];
        $rentalEndTime = $row['rental_end_time'];
        
        // Mover para o histórico
        $insertHistoryQuery = "INSERT INTO reservas_historico (computador_id, horario, aluno_nome, email_contato, status, rental_end_time, data_reserva, data_remocao)
                               VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
        $insertHistoryStmt = $conn->prepare($insertHistoryQuery);
        $status = 'disponível'; // Alterar status para 'disponível' no histórico
        $insertHistoryStmt->bind_param("issssss", $computadorId, $horario, $alunoNome, $emailContato, $status, $rentalEndTime, $dataReserva);
        
        if ($insertHistoryStmt->execute()) {
            // Limpar a reserva original
            $updateQuery = "UPDATE reservas_computadores SET aluno_nome = '', email_contato = '', status = 'disponível', rental_end_time = NULL WHERE computador_id = ? AND horario = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("is", $computadorId, $horario);
            $updateStmt->execute();
            $updateStmt->close();
        } else {
            error_log("Erro ao mover reserva para o histórico: " . $conn->error);
        }
        
        $insertHistoryStmt->close();
    }
}

$result->close();
$conn->close();
?>
