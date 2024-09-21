<?php
// Permitir o acesso de qualquer origem
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

define('DB_HOST', 'tccappionic-bd.mysql.uhserver.com'); // Host do banco de dados
define('DB_USER', 'ionic_perfil_bd'); // Usuário do banco de dados
define('DB_PASS', '{[UOLluiz2019'); // Senha do banco de dados
define('DB_NAME', 'tccappionic_bd'); // Nome do banco de dados

// Conexão com o banco de dados
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Erro de conexão com o servidor.']);
    exit;
}

// Define o tempo de 30 segundos
$tempoLimite = 30;

// Obtém a data e hora atual
$dataAtual = new DateTime();

// Calcula a data e hora que deve ser verificada
$dataLimite = $dataAtual->sub(new DateInterval('PT' . $tempoLimite . 'S'));

// Atualiza as reservas que estão dentro do limite
$updateQuery = "UPDATE reservas_computadores SET aluno_nome = '', email_contato = '', status = 'disponível' 
                WHERE status = 'reservado' AND NOW() >= (data_reserva + INTERVAL ? SECOND)";

$stmt = $conn->prepare($updateQuery);
$stmt->bind_param("i", $tempoLimite);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Reservas atualizadas com sucesso!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao atualizar reservas.']);
}

$stmt->close();
$conn->close();
?>
