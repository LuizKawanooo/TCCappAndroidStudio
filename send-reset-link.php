<?php
// Recebe o e-mail do cliente
$data = json_decode(file_get_contents('php://input'), true);
$email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['message' => 'E-mail inválido.']);
    exit;
}

// Gera um token único
$token = bin2hex(random_bytes(16));

// Conectar ao banco de dados remoto
$dsn = 'mysql:host=tccappionic-bd.mysql.uhserver.com;dbname=tccappionic_bd';
$username = 'ionic_perfil_bd';
$password = '{[UOLluiz2019';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Salva o token e o e-mail no banco de dados
    $statement = $pdo->prepare('INSERT INTO password_resets (email, token) VALUES (:email, :token)');
    $statement->execute(['email' => $email, 'token' => $token]);

    // Envia o e-mail
    $resetLink = "AppIonicTCC://reset?token=$token";
    $to = $email;
    $subject = 'Redefinição de Senha';
    $message = "Clique no link para redefinir sua senha: $resetLink";
    $headers = "From: juviscreudo2@gmail.com\r\n";

    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(['message' => 'Link de redefinição enviado com sucesso.']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Erro ao enviar o e-mail.']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Erro ao conectar ao banco de dados: ' . $e->getMessage()]);
}
?>
