<?php
// reservar.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Definições do banco de dados
define('DB_HOST', 'tccappionic-bd.mysql.uhserver.com');
define('DB_USER', 'ionic_perfil_bd');
define('DB_PASS', '{[UOLluiz2019');
define('DB_NAME', 'tccappionic_bd');

// Conexão com o banco de dados
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verifica a conexão
if (!$conn) {
    die(json_encode(['success' => false, 'message' => 'Falha na conexão: ' . mysqli_connect_error()]));
}

// Obtém o conteúdo da requisição POST
$data = json_decode(file_get_contents('php://input'), true);

// Verifica se todos os campos necessários foram enviados
if (
    isset($data['computador_id']) &&
    isset($data['horario']) &&
    isset($data['aluno_nome']) &&
    isset($data['email_contato'])
) {
    $computadorId = $data['computador_id'];
    $horario = $data['horario'];
    $alunoNome = $data['aluno_nome'];
    $emailContato = $data['email_contato'];

    // Verifica se o horário já está reservado
    $checkSql = "SELECT * FROM reservas_computadores WHERE computador_id = '$computadorId' AND horario = '$horario'";
    $checkResult = mysqli_query($conn, $checkSql);

    if (mysqli_num_rows($checkResult) > 0) {
        echo json_encode(['success' => false, 'message' => 'Horário já reservado!']);
        exit;
    }

    // Insere a nova reserva
    $insertSql = "INSERT INTO reservas_computadores (computador_id, horario, aluno_nome, email_contato) VALUES ('$computadorId', '$horario', '$alunoNome', '$emailContato')";
    if (mysqli_query($conn, $insertSql)) {
        echo json_encode(['success' => true, 'message' => 'Reserva realizada com sucesso!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao reservar horário: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Dados incompletos para reserva.']);
}

// Fecha a conexão
mysqli_close($conn);

