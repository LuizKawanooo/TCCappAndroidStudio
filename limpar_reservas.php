<?php
// Conexão com o banco de dados
define('DB_HOST', 'tccappionic-bd.mysql.uhserver.com');
define('DB_USER', 'ionic_perfil_bd');
define('DB_PASS', '{[UOLluiz2019');
define('DB_NAME', 'tccappionic_bd');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Erro de conexão: ' . $conn->connect_error]));
}

// Obtém o ID do computador da requisição
$computadorId = isset($_GET['computadorId']) ? intval($_GET['computadorId']) : 0;

if ($computadorId > 0) {
    // Limpa a reserva do banco de dados
    $updateQuery = "UPDATE reservas_computadores SET horario = NULL, aluno_nome = NULL, email_contato = NULL WHERE id = $computadorId";
    if ($conn->query($updateQuery) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Reserva limpa com sucesso.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao limpar a reserva: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID do computador inválido.']);
}

$conn->close();
?>
