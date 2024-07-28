<?php
// Configurações do banco de dados
$host = 'tccappionic-bd.mysql.uhserver.com';
$db   = 'tccappionic_bd';
$user = 'ionic_perfil_bd';
$pass = '{[UOLluiz2019';

// Conectar ao banco de dados
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro ao conectar ao banco de dados.']);
    exit;
}

// Recebe o token e a nova senha
$data = json_decode(file_get_contents('php://input'));
$token = isset($data->token) ? $data->token : '';
$nova_senha = isset($data->nova_senha) ? $data->nova_senha : '';

if (empty($token) || empty($nova_senha)) {
    echo json_encode(['success' => false, 'message' => 'Token ou nova senha não fornecidos.']);
    exit;
}

// Verifica se o token é válido
try {
    $stmt = $pdo->prepare("SELECT user_id, expires_at FROM reset_tokens WHERE token = ? AND expires_at > NOW()");
    $stmt->execute([$token]);
    $resetToken = $stmt->fetch();
    
    if (!$resetToken) {
        echo json_encode(['success' => false, 'message' => 'Token inválido ou expirado.']);
        exit;
    }

    // Atualiza a senha do usuário
    $stmt = $pdo->prepare("UPDATE registrar_usuarios SET senha = ? WHERE id = ?");
    $stmt->execute([password_hash($nova_senha, PASSWORD_DEFAULT), $resetToken['user_id']]);

    // Remove o token após o uso
    $stmt = $pdo->prepare("DELETE FROM reset_tokens WHERE token = ?");
    $stmt->execute([$token]);

    echo json_encode(['success' => true, 'message' => 'Senha alterada com sucesso.']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro ao processar a solicitação.']);
}
?>
