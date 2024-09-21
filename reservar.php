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

// Verifica a conexão com o banco de dados
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Falha na conexão: ' . $conn->connect_error]));
}

// Obtém os dados do POST
$data = json_decode(file_get_contents("php://input"));

$computadorId = $data->computador_id;
$horario = $data->horario;
$alunoNome = $data->aluno_nome;
$emailContato = $data->email_contato;

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

// Se não existir, continua para inserir a nova reserva
$insertQuery = "INSERT INTO reservas_computadores (computador_id, horario, aluno_nome, email_contato) VALUES (?, ?, ?, ?)";
$insertStmt = $conn->prepare($insertQuery);
$insertStmt->bind_param("isss", $computadorId, $horario, $alunoNome, $emailContato);

if ($insertStmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Reserva realizada com sucesso!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao realizar a reserva: ' . $insertStmt->error]);
}

$insertStmt->close();
$stmt->close();
$conn->close();
?>
