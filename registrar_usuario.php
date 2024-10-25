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

// Decodifica os dados da requisição
$data = json_decode(file_get_contents('php://input'), true);

// Extraindo os dados
$cod_instituicao = isset($data['cod_instituicao']) ? $data['cod_instituicao'] : null;
$email = isset($data['email']) ? $data['email'] : null;
$rm = isset($data['rm']) ? $data['rm'] : null;
$senha = isset($data['senha']) ? $data['senha'] : null;

// Validate input data
if (empty($cod_instituicao) || empty($email) || empty($rm) || empty($senha)) {
    echo json_encode(['success' => false, 'message' => 'Todos os campos são obrigatórios.']);
    exit();
}



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
    echo json_encode(['success' => false, 'message' => 'Erro de conexão com o banco de dados: ' . $e->getMessage()]);
    exit();
}

try {
    // Verificar se o RM já está cadastrado
    $stmt = $pdo->prepare('SELECT * FROM registrar_usuarios WHERE rm = ?');
    $stmt->execute([$rm]);
    $existingUser = $stmt->fetch();

    if ($existingUser) {
        // RM já existe, retorna uma mensagem de erro
        echo json_encode(['success' => false, 'message' => 'RM já cadastrado.']);
        exit();
    }

    // Insira o novo usuário no banco de dados
    $pontos = 0; // Ou outro valor conforme sua lógica

    $stmt = $pdo->prepare('INSERT INTO registrar_usuarios (cod_instituicao, email, rm, senha, pontos) VALUES (?, ?, ?, ?, ?)');
    $success = $stmt->execute([$cod_instituicao, $email, $rm, $senha, $pontos]);

    if ($success) {
        echo json_encode(['success' => true, 'message' => 'Usuário registrado com sucesso!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Falha ao registrar o usuário.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erro ao registrar usuário: ' . $e->getMessage()]);
}
?>
