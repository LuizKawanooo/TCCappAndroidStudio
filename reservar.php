<?php
// Permitir o acesso de qualquer origem
header('Access-Control-Allow-Origin: *');
// Permitir métodos HTTP específicos
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
// Permitir cabeçalhos específicos
header('Access-Control-Allow-Headers: Content-Type, Authorization');

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
$data = json_decode(file_get_contents("php://input"));

$computadorId = $data->computador_id;
$horario = $data->horario;
$alunoNome = $data->aluno_nome;
$emailContato = $data->email_contato;

// Verifica se os campos obrigatórios estão preenchidos
if (empty($alunoNome) || empty($emailContato)) {
    echo json_encode(['success' => false, 'message' => 'Nome e e-mail são obrigatórios.']);
    exit;
}

// Formata o horário para o formato correto (HH:MM:SS)
$horarioFormatado = date("H:i:s", strtotime($horario));

// Verifica se o computador já está reservado
$query = "SELECT * FROM reservas_computadores WHERE computador_id = ? AND status = 'reservado' AND horario = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $computadorId, $horarioFormatado);
$stmt->execute();
$result = $stmt->get_result();

// Se já existir uma reserva
if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Esse horário já está reservado. Por favor, escolha outro.']);
} else {
    // Insere a nova reserva
    $insertQuery = "INSERT INTO reservas_computadores (computador_id, horario, aluno_nome, email_contato, status, data_reserva) VALUES (?, ?, ?, ?, 'reservado', NOW())";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("isss", $computadorId, $horarioFormatado, $alunoNome, $emailContato);
    
    if ($insertStmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Reserva realizada com sucesso!']);
        
        // Espera 30 segundos
        sleep(30);

        // Atualiza a reserva para zerar os campos de nome e email
        $updateQuery = "UPDATE reservas_computadores SET aluno_nome = '', email_contato = '', status = 'disponível' WHERE computador_id = ? AND horario = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("is", $computadorId, $horarioFormatado);
        $updateStmt->execute();
        $updateStmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Ocorreu um erro ao tentar realizar a reserva. Por favor, tente novamente.']);
    }
}

$stmt->close();
$insertStmt->close();
$conn->close();
?>
