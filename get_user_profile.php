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

// Retrieve userId from GET parameter or JSON input
$userId = isset($_GET['id']) ? $_GET['id'] : json_decode(file_get_contents('php://input'), true)['userId'];

// Check if userId was provided
if (!$userId) {
    echo json_encode(['success' => false, 'message' => 'User ID not provided.']);
    exit();
}

// Database configuration
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
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit();
}

// Adjusted query to use userId
$stmt = $pdo->prepare('SELECT nome_exibicao, celular, imagem_perfil FROM registrar_usuarios WHERE id = ?');
$stmt->execute([$userId]);
$perfil = $stmt->fetch();

if ($perfil) {
    echo json_encode(['success' => true, 'profile' => $perfil]);
} else {
    echo json_encode(['success' => false, 'message' => 'Usuário não encontrado']);
}
?>
