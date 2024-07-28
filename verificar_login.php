<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$rm = $data['rm'];
$senha = $data['senha'];

// Configurações do banco de dados
$host = 'localhost';
$db   = 'nome_do_banco';
$user = 'usuario';
$pass = 'senha';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
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

$stmt = $pdo->prepare('SELECT * FROM usuarios WHERE rm = ? AND senha = ?');
$stmt->execute([$rm, $senha]);
$usuario = $stmt->fetch();

if ($usuario) {
    echo json_encode(['success' => true, 'message' => 'Login bem-sucedido']);
} else {
    echo json_encode(['success' => false, 'message' => 'RM ou senha incorretos']);
}
?>
