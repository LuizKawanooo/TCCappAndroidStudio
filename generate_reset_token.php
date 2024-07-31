<?php
<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php';

// Resto do código PHP
?>

// Configuração do servidor SMTP
$mail = new PHPMailer(true);

function sendResetEmail($email, $token) {
    global $mail;
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
    $token = generateResetToken($email);
    if (sendResetEmail($email, $token)) {
        echo json_encode(["message" => "Email de recuperação enviado!"]);
    } else {
        echo json_encode(["message" => "Erro ao enviar o e-mail. Tente novamente mais tarde."]);
    }
}
?>


















<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php';

function sendRecoveryEmail($email) {
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
        $mail->isHTML(true);
        $mail->Subject = 'Instruções de Recuperação de Senha';
        $mail->Body    = "Para redefinir sua senha, por favor, acesse a página de recuperação em <a href='https://endologic.com.br/tcc/reset_password.php'>Recuperar senha</a> e siga as instruções.";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    if (sendRecoveryEmail($email)) {
        echo json_encode(["message" => "Email de recuperação enviado!"]);
    } else {
        echo json_encode(["message" => "Erro ao enviar o e-mail. Tente novamente mais tarde."]);
    }
}
?>

