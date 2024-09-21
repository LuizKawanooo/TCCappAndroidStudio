<?php
// reservar.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

define('DB_HOST', 'tccappionic-bd.mysql.uhserver.com');
define('DB_USER', 'ionic_perfil_bd');
define('DB_PASS', '{[UOLluiz2019');
define('DB_NAME', 'tccappionic_bd');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Conexão falhou: ' . $conn->connect_error]));
}

$data = json_decode(file_get_contents("php://input"));

$computadorId = $data->computador_id;
$horario = $data->horario; // Esperando que seja no formato 'HH:MM:SS'
$alunoNome = $data->aluno_nome;
$emailContato = $data->email_contato;

// Log da entrada
error_log("Tentando reservar: Computador ID: $computadorId, Horário: $horario");

// Verifica se já existe uma reserva para o computador e horário selecionados
$query = "SELECT * FROM reservas_computadores WHERE computador_id = ? AND horario = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $computadorId, $horario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Esse horário já está reservado.']);
    exit;
}

// Insere a nova reserva
$insertQuery = "INSERT INTO reservas_computadores (computador_id, horario, aluno_nome, email_contato) VALUES (?, ?, ?, ?)";
$stmtInsert = $conn->prepare($insertQuery);
$stmtInsert->bind_param("isss", $computadorId, $horario, $alunoNome, $emailContato);
if ($stmtInsert->execute()) {
    echo json_encode(['success' => true, 'message' => 'Reserva realizada com sucesso!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao reservar: ' . $stmtInsert->error]);
}

$stmt->close();
$stmtInsert->close();
$conn->close();
?>

