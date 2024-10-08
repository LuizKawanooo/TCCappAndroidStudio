<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

header('Content-Type: application/json');

// Recebe o input JSON
$data = json_decode(file_get_contents('php://input'), true);

// Verifica se todos os parâmetros necessários estão presentes
if (!isset($data['rm']) || !isset($data['nome']) || !isset($data['celular'])) {
    echo json_encode(['success' => false, 'message' => 'Dados incompletos']);
    exit();
}

$rm = $data['rm'];
$nome = $data['nome'];
$celular = $data['celular'];

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
    $stmt = $pdo->prepare('UPDATE registrar_usuarios SET nome_exibicao = ?, celular = ? WHERE rm = ?');
    $result = $stmt->execute([$nome, $celular, $rm]);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Perfil atualizado com sucesso']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar perfil']);
    }
} catch (\PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro ao atualizar perfil: ' . $e->getMessage()]);
}
?>
