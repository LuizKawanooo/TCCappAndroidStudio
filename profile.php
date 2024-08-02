<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

header('Content-Type: application/json');

// Obtém o identificador do usuário enviado na requisição
$data = json_decode(file_get_contents('php://input'), true);

// Verifica se o identificador do usuário foi fornecido
if (!isset($data['rm'])) {
    echo json_encode(['success' => false, 'message' => 'RM não fornecido']);
    exit();
}

$rm = $data['rm'];

// Configurações do banco de dados
$host = 'tccappionic-bd.mysql.uhserver.com';
$db   = 'tccappionic_bd';
$user = 'ionic_perfil_bd';
$pass = '{[UOLluiz2019';
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
    echo json_encode(['success' => false, 'message' => 'Erro na conexão com o banco de dados']);
    exit();
}

// Prepara e executa a consulta para obter o perfil do usuário
$stmt = $pdo->prepare('SELECT rm, nome, email FROM registrar_usuarios WHERE rm = ?');
$stmt->execute([$rm]);
$usuario = $stmt->fetch();

$response = [];
if ($usuario) {
    $response['success'] = true;
    $response['data'] = $usuario;
} else {
    $response['success'] = false;
    $response['message'] = 'Usuário não encontrado';
}

echo json_encode($response);
?>
