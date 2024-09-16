<?php
// Configurações de conexão
$host = 'tccappionic-bd.mysql.uhserver.com';
$db = 'tccappionic_bd';
$user = 'ionic_perfil_bd';
$pass = '{[UOLluiz2019'; // Substitua com sua senha

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Processa a solicitação de reserva
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $horario = $data['horario'];
    $computador_id = $data['computador_id'];

    // Atualiza o horário para reservado
    $stmt = $pdo->prepare('UPDATE horarios SET status = 1, btnVermelho = "Sim" WHERE horario = ? AND computador_id = ?');
    $stmt->execute([$horario, $computador_id]);

    // Retorna a resposta
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Método HTTP não suportado']);
}
?>
