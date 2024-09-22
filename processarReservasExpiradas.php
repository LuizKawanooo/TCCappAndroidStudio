<?php
// Conexão com o banco de dados
define('DB_HOST', 'tccappionic-bd.mysql.uhserver.com');
define('DB_USER', 'ionic_perfil_bd');
define('DB_PASS', '{[UOLluiz2019');
define('DB_NAME', 'tccappionic_bd');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro de conexão com o banco de dados: " . $conn->connect_error);
}

// Obtém todas as reservas expiradas (onde o rental_end_time é menor que o horário atual)
$query = "SELECT * FROM reservas_computadores WHERE rental_end_time <= NOW() AND status = 'reservado'";
$result = $conn->query($query);

// Processa cada reserva expirada
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $computadorId = $row['computador_id'];
        $horario = $row['horario'];
        $alunoNome = $row['aluno_nome'];
        $emailContato = $row['email_contato'];
        $dataReserva = $row['data_reserva'];
        $rentalEndTime = $row['rental_end_time'];

        // Move a reserva para o histórico
        $insertHistoryQuery = "INSERT INTO reservas_historico (computador_id, horario, aluno_nome, email_contato, data_reserva, rental_end_time, data_remocao)
                               VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $insertHistoryStmt = $conn->prepare($insertHistoryQuery);
        $insertHistoryStmt->bind_param("isssss", $computadorId, $horario, $alunoNome, $emailContato, $dataReserva, $rentalEndTime);

        if ($insertHistoryStmt->execute()) {
            // Limpa os dados da reserva original, mantendo o status como 'disponível'
            $updateQuery = "UPDATE reservas_computadores SET aluno_nome = '', email_contato = '', status = 'disponível', rental_end_time = NULL WHERE computador_id = ? AND horario = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("is", $computadorId, $horario);
            $updateStmt->execute();
            $updateStmt->close();
        }

        $insertHistoryStmt->close();
    }
}

$result->close();
$conn->close();
?>
