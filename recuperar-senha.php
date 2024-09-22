<?php

// Configurações de cabeçalhos CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json');

// Conexão com o banco de dados
require 'db.php';

// Recebe o email do cliente
$email = $_POST['email'];

// Verifica se o email está registrado
$query = $pdo->prepare("SELECT id FROM password_resets WHERE email = :email");
$query->execute(['email' => $email]);
$user = $query->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $user_id = $user['id'];
    $token = bin2hex(random_bytes(32));
    
    // Insere o token no banco de dados
    $stmt = $pdo->prepare("INSERT INTO senha_recovery_tokens (user_id, token) VALUES (:user_id, :token)");
    $stmt->execute(['user_id' => $user_id, 'token' => $token]);

    // Envia o link de recuperação por email
    if (preg_match('/@etec\.sp\.gov\.br$/', $email)) {
        // Lógica para email institucional
        $reset_link = "AppIonicTCC://recuperar-senha?token=$token";
    } else {
        // Lógica para outros emails
        $reset_link = "AppIonicTCC://resetar-senha?token=$token";
    }

    $to = $email;
    $subject = "Recuperação de Senha";
    $message = "Clique no link para recuperar sua senha: $reset_link";
    $headers = "From: no-reply@bibliotec.com";
    
    mail($to, $subject, $message, $headers);

    echo json_encode(["success" => true, "message" => "Um link de recuperação de senha foi enviado para seu email."]);
} else {
    echo json_encode(["success" => false, "message" => "Email não encontrado."]);
}
?>
