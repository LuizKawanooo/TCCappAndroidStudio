<?php

// Configurações de cabeçalhos CORS
header('Access-Control-Allow-Origin: http://localhost:8100'); // Altere para o seu domínio de origem
header('Access-Control-Allow-Methods: POST, OPTIONS'); // Permita os métodos necessários
header('Access-Control-Allow-Headers: Content-Type'); // Permita os cabeçalhos necessários
header('Content-Type: application/json');

// Verifica se a solicitação é do tipo OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit; // Se for uma solicitação OPTIONS, apenas saia
}

// Conexão com o banco de dados
require 'db.php';

// Recebe o email do cliente
$email = $_POST['email'];

// Validação do email institucional
if (!preg_match('/@etec\.sp\.gov\.br$/', $email) && !preg_match('/@fatec\.sp\.gov\.br$/', $email)) {
    echo json_encode(["message" => "Email deve ser institucional (@etec.sp.gov.br ou @fatec.sp.gov.br)."]);
    exit();
}

// Verifica se o email está registrado
$query = $pdo->prepare("SELECT id FROM registrar_usuarios WHERE email = :email");
$query->execute(['email' => $email]);
$user = $query->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $user_id = $user['id'];
    $token = bin2hex(random_bytes(32));
    
    // Insere o token no banco de dados
    $stmt = $pdo->prepare("INSERT INTO password_resets (user_id, token) VALUES (:user_id, :token)");
    $stmt->execute(['user_id' => $user_id, 'token' => $token]);

    // Envia o link de recuperação por email
    $reset_link = "AppIonicTCC://telaRec?token=$token";
    $to = $email;
    $subject = "Recuperação de Senha";
    $message = "Clique no link para recuperar sua senha: $reset_link";
    $headers = "From: no-reply@seuapp.com";
    
    mail($to, $subject, $message, $headers);

    echo json_encode(["message" => "Um link de recuperação de senha foi enviado para seu email."]);
} else {
    echo json_encode(["message" => "Email não encontrado "]);
}
?>
