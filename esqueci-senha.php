<?php
require 'database.php';
require 'mailer.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Verificar se o email existe no banco de dados
    $stmt = $pdo->prepare('SELECT id FROM usuarios WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $token = bin2hex(random_bytes(50));
        $stmt = $pdo->prepare('INSERT INTO password_resets (email, token) VALUES (?, ?)');
        $stmt->execute([$email, $token]);

        $resetLink = "https://endologic.com.br/tcc/resetar-senha?token=$token";
        $mail = new PHPMailer(true);
        $mail->setFrom('luizcavano@gmail.com', 'TCC Teste');
        $mail->addAddress($email);
        $mail->Subject = 'Redefinição de Senha';
        $mail->Body    = "Clique no link para redefinir sua senha: $resetLink";

        if ($mail->send()) {
            echo json_encode(['message' => 'Link de redefinição enviado.']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Erro ao enviar o email.']);
        }
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'Email não encontrado.']);
    }
}
?>
