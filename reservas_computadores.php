<?php

// Permitir acesso de qualquer origem
header("Access-Control-Allow-Origin: *");

// Permitir métodos específicos
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");

// Permitir cabeçalhos específicos
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Caso o método seja OPTIONS, apenas retorne um status 200
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Configuração do banco de dados
$host = 'tccappionic-bd.mysql.uhserver.com';
$db_name = 'tccappionic_bd';
$username = 'ionic_perfil_bd';
$password = '{[UOLluiz2019';
$dsn = "mysql:host=$host;dbname=$db_name;charset=utf8";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro de conexão: ' . $e->getMessage()]);
    exit;
}

// Verifica a requisição
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        listarReservas($pdo);
        break;

    case 'POST':
        adicionarReserva($pdo);
        break;

    case 'DELETE':
        limparReservas($pdo);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Método não suportado.']);
        break;
}

// Função para listar reservas
function listarReservas($pdo) {
    $stmt = $pdo->query("SELECT * FROM reservas_computadores");
    $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'data' => $reservas]);
}

// Função para adicionar uma reserva
function adicionarReserva($pdo) {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['computador_id'], $data['horario'], $data['aluno_nome'], $data['email_contato'])) {
        echo json_encode(['success' => false, 'message' => 'Dados incompletos.']);
        return;
    }

    $computador_id = $data['computador_id'];
    $horario = $data['horario'];
    $aluno_nome = $data['aluno_nome'];
    $email_contato = $data['email_contato'];
    $data_reserva = date('Y-m-d H:i:s');
    $rental_end_time = date('Y-m-d H:i:s', strtotime('+30 minutes'));
    $status = 1; // Exemplo: 1 para "reservado"

    $stmt = $pdo->prepare("INSERT INTO reservas_computadores (computador_id, horario, aluno_nome, email_contato, data_reserva, rental_end_time, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    try {
        if ($stmt->execute([$computador_id, $horario, $aluno_nome, $email_contato, $data_reserva, $rental_end_time, $status])) {
            echo json_encode(['success' => true, 'message' => 'Reserva adicionada com sucesso!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao adicionar reserva.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erro ao adicionar reserva: ' . $e->getMessage()]);
    }
}

// Função para limpar reservas antigas
function limparReservas($pdo) {
    $stmt = $pdo->prepare("DELETE FROM reservas_computadores WHERE TIMESTAMPDIFF(SECOND, data_reserva, NOW()) > 1800");
    
    try {
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Reservas antigas limpas com sucesso!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao limpar reservas.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erro ao limpar reservas: ' . $e->getMessage()]);
    }
}
?>
