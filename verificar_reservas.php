<?php
// Permitir acesso de qualquer origem
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

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

// Função para mover reservas expiradas para o histórico e remover da tabela original
function moverReservasExpiradas($pdo) {
    // Seleciona as reservas expiradas
    $stmt = $pdo->prepare("SELECT * FROM reservas_computadores WHERE DATE_ADD(data_reserva, INTERVAL 30 SECOND) < NOW()");
    $stmt->execute();
    $reservasExpiradas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($reservasExpiradas) > 0) {
        foreach ($reservasExpiradas as $reserva) {
            // Mover para reservas_historico
            $insertStmt = $pdo->prepare("INSERT INTO reservas_historico (computador_id, horario, aluno_nome, email_contato, data_reserva, rental_end_time, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $insertStmt->execute([
                $reserva['computador_id'],
                $reserva['horario'],
                $reserva['aluno_nome'],
                $reserva['email_contato'],
                $reserva['data_reserva'],
                $reserva['rental_end_time'],
                $reserva['status']  // Certifique-se de que a coluna status existe em reservas_historico
            ]);

            // Remover da tabela reservas_computadores
            $deleteStmt = $pdo->prepare("DELETE FROM reservas_computadores WHERE id = ?");
            $deleteStmt->execute([$reserva['id']]);
        }
        echo json_encode(['success' => true, 'message' => 'Reservas expiradas movidas para o histórico.']);
    } else {
        echo json_encode(['success' => true, 'message' => 'Nenhuma reserva expirada encontrada.']);
    }
}

// Executa a função para mover reservas expiradas
moverReservasExpiradas($pdo);
?>
