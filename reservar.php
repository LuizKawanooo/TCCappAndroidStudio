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
    echo 'Erro de conexão: ' . $e->getMessage();
    exit;
}

// Obtém os dados da solicitação (a partir da linha de comando)
if ($argc !== 3) {
    echo "Uso: php reserve.php <horario> <computador_id>\n";
    exit;
}

$horario = $argv[1];
$computador_id = $argv[2];

try {
    // Atualiza o horário para reservado
    $stmt = $pdo->prepare('UPDATE horarios SET status = 1, btnVermelho = "Sim" WHERE horario = ? AND computador_id = ?');
    $stmt->execute([$horario, $computador_id]);

    echo "Reserva feita com sucesso.\n";
} catch (\PDOException $e) {
    echo 'Erro ao atualizar o banco de dados: ' . $e->getMessage() . "\n";
}
