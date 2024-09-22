<?php
require 'db.php'; // Conexão com o banco de dados

$email = $_POST['email'];

// Verifique se o e-mail existe no banco de dados
$query = "SELECT * FROM registrar_usuarios WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Gerar um token único
    $token = bin2hex(random_bytes(50));

    // Salvar o token no banco de dados ou enviá-lo por e-mail
    // Aqui você enviaria um e-mail com o link para redefinir a senha
    // O link deve conter o token como parâmetro

    // Exemplo de envio de e-mail
    $to = $email;
    $subject = "Recuperação de Senha - Bibliotec";
    $message = "Clique no link para redefinir sua senha: https://endologic.com.br/tcc/resetar_senha.php?token=" . $token;
    mail($to, $subject, $message);

    echo json_encode(['success' => true, 'message' => 'Um link de recuperação foi enviado para seu e-mail.']);
} else {
    echo json_encode(['success' => false, 'message' => 'E-mail não encontrado.']);
}
?>
