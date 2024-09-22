<?php
require 'db_connection.php'; // Conexão com o banco de dados

// Obtém o token e a nova senha da requisição POST
$token = $_POST['token'];
$novaSenha = $_POST['novaSenha'];

// Verifica se o token é válido
$query = "SELECT * FROM password_resets WHERE token = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Token encontrado, obtém o email associado
    $row = $result->fetch_assoc();
    $email = $row['email'];

    // Atualiza a senha no banco de dados
    $hashedPassword = password_hash($novaSenha, PASSWORD_BCRYPT);
    $updateQuery = "UPDATE registrar_usuarios SET senha = ? WHERE email = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("ss", $hashedPassword, $email);

    if ($updateStmt->execute()) {
        // Senha atualizada com sucesso, remove o token
        $deleteQuery = "DELETE FROM password_resets WHERE token = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("s", $token);
        $deleteStmt->execute();

        echo json_encode(['success' => true, 'message' => 'Senha redefinida com sucesso.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar a senha.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Token inválido.']);
}
?>
