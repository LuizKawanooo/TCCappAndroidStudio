<?php

// Configurações de cabeçalhos CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json');

// Conexão com o banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com"; // Nome do seu servidor
$username = "ionic_perfil_bd"; // Seu usuário do MySQL
$password = "{[UOLluiz2019"; // Sua senha do MySQL
$dbname = "tccappionic_bd"; // Nome do seu banco de dados

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifique a conexão
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Falha na conexão: " . $conn->connect_error]));
}

// Recebe o email do cliente
$email = $_POST['email'];

// Verifica se o email está registrado
$query = $conn->prepare("SELECT id FROM password_resets WHERE email = ?");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

if ($user) {
    $user_id = $user['id'];
    $token = bin2hex(random_bytes(32));
    
    // Insere o token no banco de dados
    $stmt = $conn->prepare("INSERT INTO senha_recovery_tokens (user_id, token) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $token);
    $stmt->execute();

    // Envia o link de recuperação por email
    if (preg_match('/@etec\.sp\.gov\.br$/', $email)) {
        // Lógica para email institucional
        $reset_link = "AppIonicTCC://recuperar-senha?token=$token";
    } else {
        // Lógica para outros emails
        $reset_link = "https://AppIonicTCC.com/resetar-senha?token=$token";
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

// Fecha a conexão
$conn->close();
?>
