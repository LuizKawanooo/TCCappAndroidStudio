<?php
// reservar.php

// Permitir o acesso de qualquer origem
header('Access-Control-Allow-Origin: *');
// Permitir métodos HTTP específicos
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
// Permitir cabeçalhos específicos
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Definições do banco de dados
define('DB_HOST', 'tccappionic-bd.mysql.uhserver.com'); // Host do banco de dados
define('DB_USER', 'ionic_perfil_bd'); // Usuário do banco de dados
define('DB_PASS', '{[UOLluiz2019'); // Senha do banco de dados
define('DB_NAME', 'tccappionic_bd'); // Nome do banco de dados

// Conexão com o banco de dados
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Erro de conexão com o servidor. Por favor, tente novamente mais tarde.']);
    exit;
}

// Recebendo os dados da requisição
$data = json_decode(file_get_contents("php://input"), true);

$computadorId = isset($data['computador_id']) ? intval($data['computador_id']) : 0;
$horario = isset($data['horario']) ? $data['horario'] : '';
$alunoNome = isset($data['aluno_nome']) ? trim($data['aluno_nome']) : '';
$emailContato = isset($data['email_contato']) ? trim($data['email_contato']) : '';

// Verifica se os campos obrigatórios estão preenchidos
if (empty($computadorId) || empty($horario) || empty($alunoNome) || empty($emailContato)) {
    echo json_encode(['success' => false, 'message' => 'Todos os campos são obrigatórios.']);
    exit;
}

// Formata o horário para o formato correto (HH:MM:SS)
$horarioFormatado = date("H:i:s", strtotime($horario));

// Verifica se o computador já está reservado naquele horário
$query = "SELECT * FROM reservas_computadores WHERE computador_id = ? AND status = 'reservado' AND horario = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $computadorId, $horarioFormatado);
$stmt->execute();
$result = $stmt->get_result();

// Se já existir uma reserva
if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Esse horário já está reservado. Por favor, escolha outro.']);
} else {
    // Define o rental_end_time para 30 segundos após a reserva
    $rentalEndTime = date("Y-m-d H:i:s", strtotime("+30 seconds"));
    
    // Insere a nova reserva
    $insertQuery = "INSERT INTO reservas_computadores (computador_id, horario, aluno_nome, email_contato, status, rental_end_time, data_reserva) VALUES (?, ?, ?, ?, 'reservado', ?, NOW())";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("issss", $computadorId, $horarioFormatado, $alunoNome, $emailContato, $rentalEndTime);
    
    if ($insertStmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Reserva realizada com sucesso!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ocorreu um erro ao tentar realizar a reserva. Por favor, tente novamente.']);
    }
    
    $insertStmt->close();
}

$stmt->close();
$conn->close();
?>
