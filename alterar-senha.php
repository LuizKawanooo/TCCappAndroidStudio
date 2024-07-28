<?php
// Configurações do banco de dados
$host = 'tccappionic-bd.mysql.uhserver.com';
$db   = 'tccappionic_bd';
$user = 'ionic_perfil_bd';
$pass = '{[UOLluiz2019';

// Conectar ao banco de dados
$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Recebe o token da solicitação
$data = json_decode(file_get_contents('php://input'));
$token = $data->token ?? '';

// Verifica se o token foi fornecido
if (empty($token)) {
    echo json_encode(['success' => false, 'message' => 'Token não fornecido.']);
    exit;
}

// Verifica se o token é válido
$stmt = $pdo->prepare("SELECT user_id FROM reset_tokens WHERE token = ? AND expires_at > NOW()");
$stmt->execute([$token]);
$tokenData = $stmt->fetch();

if (!$tokenData) {
    echo json_encode(['success' => false, 'message' => 'Token inválido ou expirado.']);
    exit;
}

// Token válido, processar a solicitação para redefinir a senha
$user_id = $tokenData['user_id'];

// Aqui você pode criar um endpoint para a redefinição da senha ou processar a redefinição diretamente
// Exemplo: gerar uma nova senha e atualizar no banco de dados

echo json_encode(['success' => true, 'message' => 'Token válido. Você pode prosseguir com a redefinição da senha.']);
?>
