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
    echo json_encode(['success' => false, 'message' => 'Erro de conexão: ' . $conn->connect_error]);
    exit;
}

// Recebendo os dados da requisição
$data = json_decode(file_get_contents("php://input"));

$computadorId = $data->computador_id;
$horario = $data->horario;
$alunoNome = $data->aluno_nome;
$emailContato = $data->email_contato;

// Formata o horário para o formato correto (HH:MM:SS)
$horarioFormatado = date("H:i:s", strtotime($horario));

// Verifica se já existe uma reserva para o computador e horário selecionados
$query = "SELECT * FROM reservas_computadores WHERE computador_id = ? AND horario = ?";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param("is", $computadorId, $horarioFormatado);
    $stmt->execute();
    $result = $stmt->get_result();

    // Se já existir uma reserva
    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Esse horário já está reservado.']);
    } else {
        // Insere a nova reserva
        $insertQuery = "INSERT INTO reservas_computadores (computador_id, horario, aluno_nome, email_contato, data_reserva) VALUES (?, ?, ?, ?, NOW())";
        $insertStmt = $conn->prepare($insertQuery);

        if ($insertStmt) {
            $insertStmt->bind_param("isss", $computadorId, $horarioFormatado, $alunoNome, $emailContato);
            
            if ($insertStmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Reserva realizada com sucesso!']);
                
                // Pausa o script por 30 segundos
                sleep(30);
                
                // Atualiza a reserva para zerar os campos de nome e email
                $updateQuery = "UPDATE reservas_computadores SET aluno_nome = '', email_contato = '' WHERE computador_id = ? AND horario = ?";
                $updateStmt = $conn->prepare($updateQuery);
                
                if ($updateStmt) {
                    $updateStmt->bind_param("is", $computadorId, $horarioFormatado);
                    $updateStmt->execute();
                    $updateStmt->close();
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Erro ao fazer a reserva: ' . $insertStmt->error]);
            }
            $insertStmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao preparar a inserção: ' . $conn->error]);
        }
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao preparar a consulta: ' . $conn->error]);
}

$conn->close();
?>

