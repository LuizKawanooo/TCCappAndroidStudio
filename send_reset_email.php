<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/var/www/html/endologic.com.br/web/tcc/src/PHPMailer-master/src/Exception.php';
require '/var/www/html/endologic.com.br/web/tcc/src/PHPMailer-master/src/PHPMailer.php';
require '/var/www/html/endologic.com.br/web/tcc/src/PHPMailer-master/src/SMTP.php';


// Configurações do banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019"; // Verifique se essa senha está correta
$dbname = "tccappionic_bd";

// Cria conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitiza a entrada
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

// Verifica se o e-mail é válido
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["error" => "E-mail inválido"]);
    exit();
}

// Verifica se o e-mail existe no banco de dados
$sql = "SELECT id FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Gera um token de recuperação e define a validade (1 hora)
    $token = bin2hex(random_bytes(50));
    $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

    // Atualiza o banco de dados com o token e a validade
    $update_sql = "UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE email = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sss", $token, $expiry, $email);
    $update_stmt->execute();

    // Envia o e-mail de recuperação
    $mail = new PHPMailer(true);
    try {
        // Configurações do servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'juviscreudo19@gmail.com'; // Seu e-mail do Gmail
        $mail->Password = 'malsshwcapvlqigh'; // Sua senha de aplicativo do Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configurações do e-mail
        $mail->setFrom('juviscreudo19@gmail.com', 'juviscreudo19@gmail.com');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Recuperação de Senha';
        $mail->Body    = "Clique no link para redefinir sua senha: <a href='https://endologic.com.br/tcc/reset_password.php?token=$token'>Redefinir Senha</a>";
        $mail->AltBody = "Clique no link para redefinir sua senha: https://endologic.com.br/tcc/reset_password.php?token=$token";

        $mail->send();
        echo json_encode(["message" => "E-mail de recuperação enviado"]);
    } catch (Exception $e) {
        echo json_encode(["error" => "Erro ao enviar e-mail: {$mail->ErrorInfo}"]);
    }
} else {
    echo json_encode(["error" => "E-mail não encontrado"]);
}

$stmt->close();
$conn->close();
?>
