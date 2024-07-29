<?php
// Conexão com o banco de dados
require 'database.php';

// Recebe o email do cliente
$email = $_POST['email'];

// Verifica se o email está registrado
$query = $pdo->prepare("SELECT id FROM registrar_usuarios WHERE email = :email");
$query->execute(['email' => $email]);
$user = $query->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $user_id = $user['id'];
    $token = bin2hex(random_bytes(32));
    
    // Insere o token no banco de dados
    $stmt = $pdo->prepare("INSERT INTO senha_recovery_tokens (user_id, token) VALUES (:user_id, :token)");
    $stmt->execute(['user_id' => $user_id, 'token' => $token]);

    // Envia o link de recuperação por email
    $reset_link = "myapp://telaRec?token=$token";
    $to = $email;
    $subject = "Recuperação de Senha";
    $message = "Clique no link para recuperar sua senha: $reset_link";
    $headers = "From: no-reply@seuapp.com";
    
    mail($to, $subject, $message, $headers);

    echo "Um link de recuperação de senha foi enviado para seu email.";
} else {
    echo "Email não encontrado.";
}
?>
