<?php
// Configurações do banco de dados
$host = 'tccappionic-bd.mysql.uhserver.com';
$db   = 'tccappionic_bd';
$user = 'ionic_perfil_bd';
$pass = '{[UOLluiz2019';

// Conectar ao banco de dados
$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Recebe o e-mail do cliente
$data = json_decode(file_get_contents('php://input'));
$email = $data->email ?? '';

// Verifica se o e-mail está registrado
$stmt = $pdo->prepare("SELECT id FROM registrar_usuarios WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user) {
    echo json_encode(['success' => false, 'message' => 'E-mail não encontrado.']);
    exit;
}

// Gera um token de redefinição
$token = bin2hex(random_bytes(16));
$expires_at = date('Y-m-d H:i:s', strtotime('+1 hour')); // O link expira em 1 hora

// Armazena o token no banco de dados
$stmt = $pdo->prepare("INSERT INTO reset_tokens (user_id, token, expires_at) VALUES (?, ?, ?)");
$stmt->execute([$user['id'], $token, $expires_at]);

// Envia o e-mail
$to = $email;
$subject = "Redefinição de Senha";
$message = "Para redefinir sua senha, clique no link abaixo:\n\n";
$message .= "Para abrir o app, clique no link: myapp://alterar-senha?token=$token\n\n";
$message .= "Esse link expirará em 1 hora.";
$headers = "From: no-reply@seusite.com\r\n";
$headers .= "Reply-To: no-reply@seusite.com\r\n";

if (mail($to, $subject, $message, $headers)) {
    echo json_encode(['success' => true, 'message' => 'Link de redefinição enviado para o seu e-mail.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Falha ao enviar o e-mail.']);
}
?>
