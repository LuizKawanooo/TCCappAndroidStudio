<?php
// reservar.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Inclui o arquivo de configuração para conectar ao banco de dados
require_once 'config.php';

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

    try {
        // Conexão com o banco de dados
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verifica se o horário já está reservado na tabela reservas_computadores
        $checkStmt = $pdo->prepare("SELECT * FROM reservas_computadores WHERE computador_id = ? AND horario = ?");
        $checkStmt->execute([$computadorId, $horario]);
        if ($checkStmt->rowCount() > 0) {
            echo json_encode(['success' => false, 'message' => 'Horário já reservado!']);
            exit;
        }

        // Insere a nova reserva na tabela reservas_computadores
        $insertStmt = $pdo->prepare("INSERT INTO reservas_computadores (computador_id, horario, aluno_nome, email_contato) VALUES (?, ?, ?, ?)");
        $insertStmt->execute([$computadorId, $horario, $alunoNome, $emailContato]);

        // Retorna uma resposta de sucesso
        echo json_encode(['success' => true, 'message' => 'Reserva realizada com sucesso!']);
    } catch (PDOException $e) {
        // Em caso de erro, retorna a mensagem de erro
        echo json_encode(['success' => false, 'message' => 'Erro ao reservar horário: ' . $e->getMessage()]);
    }
} else {
    // Retorna erro se os campos não foram enviados corretamente
    echo json_encode(['success' => false, 'message' => 'Dados incompletos para reserva.']);
}
