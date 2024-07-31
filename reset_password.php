<?php
// Conectar ao banco de dados
$conn = new mysqli("seu_host", "seu_usuario", "sua_senha", "meu_banco_de_dados");

// Verificar conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $new_password = $_POST["password"];

    // Hash da nova senha
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Atualizar a senha no banco de dados
    $stmt = $conn->prepare("UPDATE registrar_usuarios SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashed_password, $email);
    
    if ($stmt->execute()) {
        $message = "Senha alterada com sucesso!";
    } else {
        $message = "Erro ao alterar a senha. Tente novamente.";
    }

    $stmt->close();
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha</title>
</head>
<body>
    <h2>Redefinir Senha</h2>
    
    <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    
    <form method="post" action="">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="password">Nova Senha:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <input type="submit" value="Redefinir Senha">
    </form>
</body>
</html>
