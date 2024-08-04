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

$data = json_decode(file_get_contents('php://input'), true);

// Verifique se o valor de 'rm' foi fornecido
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
    echo json_encode(['success' => false, 'message' => 'Erro ao conectar ao banco de dados: ' . $e->getMessage()]);
    exit();
}

try {
    // Atualize o nome da coluna de acordo com o nome correto no banco de dados
    $stmt = $pdo->prepare('SELECT nome_exibicao, celular FROM registrar_usuarios WHERE rm = ?');
    $stmt->execute([$rm]);
    $userProfile = $stmt->fetch();

    if ($userProfile) {
        echo json_encode(['success' => true, 'profile' => $userProfile]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Usuário não encontrado']);
    }
} catch (\PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro ao obter perfil: ' . $e->getMessage()]);
}
?>
