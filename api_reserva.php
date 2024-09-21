<?php
// api.php

header("Access-Control-Allow-Origin: *"); // Permite requisições de qualquer origem
header("Content-Type: application/json; charset=UTF-8"); // Define o tipo de conteúdo como JSON
header("Access-Control-Allow-Methods: GET, POST"); // Métodos permitidos
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); // Cabeçalhos permitidos

require 'config.php';

// Obtém o método HTTP e o endpoint solicitado
$method = $_SERVER['REQUEST_METHOD'];
$request = isset($_GET['request']) ? $_GET['request'] : '';

// Roteamento básico
switch ($method) {
    case 'GET':
        if ($request === 'reservas') {
            getReservas($pdo);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Endpoint não encontrado']);
        }
        break;

    case 'POST':
        if ($request === 'reservar') {
            reservarHorario($pdo);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Endpoint não encontrado']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método não permitido']);
        break;
}

// Função para obter todas as reservas
function getReservas($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM reservas_computadores ORDER BY computador_id, horario ASC");
        $stmt->execute();
        $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($reservas);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Erro ao obter reservas: ' . $e->getMessage()]);
    }
}

// Função para reservar um horário
function reservarHorario($pdo) {
    // Obtém os dados enviados no corpo da requisição
    $data = json_decode(file_get_contents("php://input"), true);

    // Validação dos dados
    if (!isset($data['computador_id'], $data['horario'], $data['aluno_nome'], $data['email_contato'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Dados incompletos para reserva']);
        exit();
    }

    $computador_id = intval($data['computador_id']);
    $horario = $data['horario'];
    $aluno_nome = trim($data['aluno_nome']);
    $email_contato = trim($data['email_contato']);

    // Validação de horários: deve ser maior que o horário atual
    $horario_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $horario);
    $now = new DateTime();

    if (!$horario_datetime) {
        http_response_code(400);
        echo json_encode(['error' => 'Formato de horário inválido']);
        exit();
    }

    if ($horario_datetime <= $now) {
        http_response_code(400);
        echo json_encode(['error' => 'O horário deve ser maior que o horário atual']);
        exit();
    }

    // Verifica se o horário está dentro do intervalo permitido
    $hora = $horario_datetime->format('H:i:s');
    if ($hora < '07:30:00' || $hora > '18:30:00') {
        http_response_code(400);
        echo json_encode(['error' => 'Horário fora do intervalo permitido (07:30 às 18:30)']);
        exit();
    }

    // Verifica se o horário está em intervalos de 30 em 30 minutos
    $minutos = $horario_datetime->format('i');
    if ($minutos != '00' && $minutos != '30') {
        http_response_code(400);
        echo json_encode(['error' => 'Horário deve estar em intervalos de 30 minutos']);
        exit();
    }

    // Inicia a transação
    try {
        $pdo->beginTransaction();

        // Verifica se o horário já está reservado
        $stmt = $pdo->prepare("SELECT status FROM reservas_computadores WHERE computador_id = :computador_id AND horario = :horario FOR UPDATE");
        $stmt->execute(['computador_id' => $computador_id, 'horario' => $horario]);
        $reserva = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$reserva) {
            // Horário não existe
            $pdo->rollBack();
            http_response_code(404);
            echo json_encode(['error' => 'Horário não encontrado']);
            exit();
        }

        if ($reserva['status'] === 'reservado') {
            // Já está reservado
            $pdo->rollBack();
            http_response_code(409); // Conflito
            echo json_encode(['error' => 'Horário já reservado']);
            exit();
        }

        // Atualiza a reserva para 'reservado'
        $updateStmt = $pdo->prepare("UPDATE reservas_computadores SET aluno_nome = :aluno_nome, email_contato = :email_contato, status = 'reservado' WHERE computador_id = :computador_id AND horario = :horario");
        $updateStmt->execute([
            'aluno_nome' => $aluno_nome,
            'email_contato' => $email_contato,
            'computador_id' => $computador_id,
            'horario' => $horario
        ]);

        // Confirma a transação
        $pdo->commit();

        echo json_encode(['message' => 'Reserva realizada com sucesso']);
    } catch (PDOException $e) {
        // Reverte a transação em caso de erro
        $pdo->rollBack();
        http_response_code(500);
        echo json_encode(['error' => 'Erro ao realizar a reserva: ' . $e->getMessage()]);
    }
}
?>
