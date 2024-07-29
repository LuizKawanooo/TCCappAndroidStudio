<?php
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $newPassword = password_hash($_POST['newPassword'], PASSWORD_BCRYPT);

    // Verificar se o token é válido
    $stmt = $pdo->prepare('SELECT email FROM password_resets WHERE token = ?');
    $stmt->execute([$token]);
    $email = $stmt->fetchColumn();

    if ($email) {
        // Atualizar a senha do usuário
        $stmt = $pdo->prepare('UPDATE registrar_usuarios SET senha = ? WHERE email = ?');
        $stmt->execute([$newPassword, $email]);

        // Remover o token de redefinição
        $stmt = $pdo->prepare('DELETE FROM password_resets WHERE token = ?');
        $stmt->execute([$token]);

        echo json_encode(['message' => 'Senha redefinida com sucesso.']);
    } else {
        http_response_code(400);
        echo json_encode(['message' => 'Token inválido.']);
    }
}
?>
