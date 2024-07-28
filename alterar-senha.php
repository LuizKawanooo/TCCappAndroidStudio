<?php
header('Content-Type: application/json');
require 'database_connection.php'; // Substitua com o caminho para o seu arquivo de conexão ao banco de dados

$data = json_decode(file_get_contents("php://input"));

if (isset($data->token) && isset($data->newPassword)) {
    $token = $data->token;
    $newPassword = password_hash($data->newPassword, PASSWORD_BCRYPT);

    // Verifica o token
    $query = "SELECT user_id, expires_at FROM reset_tokens WHERE token = ? AND expires_at > NOW()";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $resetToken = $result->fetch_assoc();
        $user_id = $resetToken['user_id'];

        // Atualiza a senha do usuário
        $query = "UPDATE usuarios SET senha = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $newPassword, $user_id);
        $stmt->execute();

        // Remove o token após a utilização
        $query = "DELETE FROM reset_tokens WHERE token = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $token);
        $stmt->execute();

        echo json_encode(["success" => true, "message" => "Senha alterada com sucesso."]);
    } else {
        echo json_encode(["success" => false, "message" => "Token inválido ou expirado."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Dados inválidos."]);
}

$conn->close();
?>
