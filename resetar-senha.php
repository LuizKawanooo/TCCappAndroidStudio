<?php
// Conexão com o banco de dados
require 'database.php';

// Recebe o token e a nova senha do cliente
$token = $_POST['token'];
$novaSenha = password_hash($_POST['novaSenha'], PASSWORD_BCRYPT);

// Verifica o token
$query = $pdo->prepare("SELECT user_id FROM senha_recovery_tokens WHERE token = :token");
$query->execute(['token' => $token]);
$record = $query->fetch(PDO::FETCH_ASSOC);

if ($record) {
    $user_id = $record['user_id'];
    
    // Atualiza a senha do usuário
    $stmt = $pdo->prepare("UPDATE registrar_usuarios SET senha = :novaSenha WHERE id = :user_id");
    $stmt->execute(['novaSenha' => $novaSenha, 'user_id' => $user_id]);

    // Remove o token
    $stmt = $pdo->prepare("DELETE FROM senha_recovery_tokens WHERE token = :token");
    $stmt->execute(['token' => $token]);

    echo "Senha redefinida com sucesso.";
} else {
    echo "Token inválido ou expirado.";
}
?>
