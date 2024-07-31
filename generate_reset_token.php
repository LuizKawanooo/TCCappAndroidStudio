<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Caminho para o diretório PHPMailer
require 'src/PHPMailer-master/src/Exception.php';
require 'src/PHPMailer-master/src/PHPMailer.php';
require 'src/PHPMailer-master/src/SMTP.php';

// Função para enviar e-mail de redefinição de senha
function sendResetEmail($email, $token) {
    $mail = new PHPMailer(true);
    try {
        // Configuração do servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Endereço do servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'juviscreudo19@gmail.com'; // Seu usuário SMTP
        $mail->Password = 'mals shwc apvl qigh'; // Sua senha SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Habilita a criptografia TLS
        $mail->Port = 587; // Porta SMTP

        // Remetente e destinatário
        $mail->setFrom('juviscreudo19@gmail.com', 'Bibliotec Ofc');
        $mail->addAddress($email);

        // Conteúdo do e-mail
        $reset_link = "https://endologic.com.br/tcc/reset_password.php?token=" . $token;
        $mail->isHTML(true);
        $mail->Subject = 'Recuperação de Senha';
        $mail->Body    = "Clique no link para resetar sua senha: <a href='$reset_link'>$reset_link</a>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Função para gerar token de redefinição
function generateResetToken($email) {
    $conn = new mysqli("tccappionic-bd.mysql.uhserver.com", "ionic_perfil_bd", "{[UOLluiz2019", "tccappionic_bd");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $reset_token = bin2hex(random_bytes(16));
    $reset_token_expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

    $stmt = $conn->prepare("UPDATE registrar_usuarios SET reset_token = ?, reset_token_expiry = ? WHERE email = ?");
    $stmt->bind_param("sss", $reset_token, $reset_token_expiry, $email);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    return $reset_token;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["message" => "Email inválido."]);
        exit;
    }

    $token = generateResetToken($email);
    if (sendResetEmail($email, $token)) {
        echo json_encode(["message" => "Email de recuperação enviado!"]);
    } else {
        echo json_encode(["message" => "Erro ao enviar o e-mail. Tente novamente mais tarde."]);
    }
}
?>
