<?php
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
    // Enviar email com o token (implemente a função sendResetEmail)
    sendResetEmail($email, $token);
    echo json_encode(["message" => "Email de recuperação enviado!"]);
}

function sendResetEmail($email, $token) {
    $reset_link = "https://endologic.com.br/tcc/reset_password.php?token=" . $token;
    $subject = "Recuperação de Senha";
    $message = "Clique no link para resetar sua senha: " . $reset_link;
    $headers = "From: juviscreudo19@gmail.com?";

    mail($email, $subject, $message, $headers);
}
?>
