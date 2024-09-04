<?php
require 'db.php';
require 'vendor/autoload.php'; // Inclua o autoload do Composer para PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Verifica se o e-mail está registrado
    $stmt = $conn->prepare("SELECT id FROM registrar_usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id);
        $stmt->fetch();

        // Gera o token de redefinição de senha
        $token = bin2hex(random_bytes(16)); // Gerar token seguro
        $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token expira em 1 hora

        // Armazena o token no banco de dados
        $stmt = $conn->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE token = VALUES(token), expires_at = VALUES(expires_at)");
        $stmt->bind_param("iss", $user_id, $token, $expires_at);
        $stmt->execute();

        // Envia o e-mail
        $mail = new PHPMailer(true);
        try {
            // Configurações do servidor de e-mail
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'Bibliotec Ofc';
            $mail->Password = 'xyev ffse ebgo tcpr';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Destinatário
            $mail->setFrom('juviscreudo19@gmail.com', 'Your Name');
            $mail->addAddress($email);

            // Conteúdo do e-mail
            $mail->isHTML(true);
            $mail->Subject = 'Link para Recuperação de Senha';
            $mail->Body = 'Clique no link para redefinir sua senha: <a href="http://localhost/reset_password.php?token=' . $token . '">Redefinir Senha</a>';

            $mail->send();
            echo 'Email de recuperação enviado';
        } catch (Exception $e) {
            echo 'Erro ao enviar e-mail: ', $mail->ErrorInfo;
        }
    } else {
        echo 'E-mail não encontrado';
    }
}
?>
