<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Get the JSON input data
$data = json_decode(file_get_contents('php://input'), true);

// Retrieve RM and senha
$rm = $data['rm'];
$senha = $data['senha'];

// Database connection settings
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
    echo json_encode(['success' => false, 'message' => 'Database connection error.']);
    exit();
}

// Prepare and execute the SQL statement
$stmt = $pdo->prepare('SELECT * FROM registrar_usuarios WHERE rm = ?');
$stmt->execute([$rm]);
$usuario = $stmt->fetch();

// Verify the password using password_verify if the user exists
if ($usuario && password_verify($senha, $usuario['senha'])) {
    echo json_encode([
        'success' => true,
        'message' => 'Login bem-sucedido',
        'email' => $usuario['email'] // Return the user email
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'RM ou senha incorretos']);
}
?>
