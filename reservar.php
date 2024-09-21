<?php
// Permitir o acesso de qualquer origem
header('Access-Control-Allow-Origin: *');
// Permitir métodos HTTP específicos
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
// Permitir cabeçalhos específicos
header('Access-Control-Allow-Headers: Content-Type, Authorization');


// Configurações do banco de dados
define('DB_HOST', 'tccappionic-bd.mysql.uhserver.com');
define('DB_USER', 'ionic_perfil_bd');
define('DB_PASS', '{[UOLluiz2019');
define('DB_NAME', 'tccappionic_bd');

// Conecta ao banco de dados
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verifica a conexão
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Erro de conexão: ' . $conn->connect_error]));
}

// Obtém os dados da requisição
$data = json_decode(file_get_contents("php://input"));
$computadorId = $data->computador_id;
$horario = $data->horario;
$alunoNome = $data->aluno_nome;
$emailContato = $data->email_contato;

// Formata o horário
$horarioFormatado = date("H:i", strtotime($horario));

// Verifica se o horário está no formato correto
if (!preg_match("/^\d{2}:\d{2}$/", $horarioFormatado)) {
    echo json_encode(['success' => false, 'message' => 'Formato de horário inválido.']);
    exit;
}

// Verifica se já existe uma reserva para o computador e horário selecionados
$query = "SELECT * FROM reservas_computadores WHERE computador_id = ? AND horario = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $computadorId, $horarioFormatado);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Esse horário já está reservado.']);
    exit;
}

// Se não existir, continua para inserir a nova reserva
$query = "INSERT INTO reservas_computadores (computador_id, horario, aluno_nome, email_contato) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("isss", $computadorId, $horarioFormatado, $alunoNome, $emailContato);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Reserva feita com sucesso.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao fazer a reserva: ' . $stmt->error]);
}

// Fecha a conexão
$stmt->close();
$conn->close();
?>
