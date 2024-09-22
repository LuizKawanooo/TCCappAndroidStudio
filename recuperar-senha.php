<?php

// Configurações de cabeçalhos CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

// Conexão com o banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com"; 
$username = "ionic_perfil_bd"; 
$password = "{[UOLluiz2019"; 
$dbname = "tccappionic_bd"; 

// Crie a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifique a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Recebe o email do cliente
$email = trim($_POST['email']);

// Verifica se o email está registrado
$query = $conn->prepare("SELECT id FROM registrar_usuarios WHERE email = ?");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user_id = $user['id'];
    $token = bin2hex(random_bytes(32));

    // Atualiza o token na tabela
    $stmt = $conn->prepare("UPDATE registrar_usuarios SET token = ? WHERE id = ?");
    $stmt->bind_param("si", $token, $user_id);

    if (!$stmt->execute()) {
        echo json_encode(["success" => false, "message" => "Erro ao atualizar o token."]);
        exit();
    }

    // Envia o link de recuperação por email
    if (preg_match('/@etec\.sp\.gov\.br$/', $email)) {
        $reset_link = "AppIonicTCC://recuperar-senha?token=$token";
    } else {
        $reset_link = "AppIonicTCC://resetar-senha?token=$token";
    }

    $to = $email;
    $subject = "Recuperação de Senha";
    $message = "Clique no link para recuperar sua senha: $reset_link";
    $headers = "From: no-reply@bibliotec.com";

    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(["success" => true, "message" => "Um link de recuperação de senha foi enviado para seu email."]);
    } else {
        echo json_encode(["success" => false, "message" => "Erro ao enviar o email."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Email não encontrado."]);
}

$conn->close();
?>
