<?php
// Configurações do banco de dados
$host = 'tccappionic-bd.mysql.uhserver.com';
$db   = 'tccappionic_bd';
$user = 'ionic_perfil_bd';
$pass = '{[UOLluiz2019';

// Conectar ao banco de dados
$conn = new mysqli($host, $user, $pass, $db);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Receber dados da requisição
$data = json_decode(file_get_contents("php://input"));

if (isset($data->token) && isset($data->senha)) {
    $token = $conn->real_escape_string($data->token);
    $nova_senha = $conn->real_escape_string($data->senha);

    // Verificar se o token existe na tabela de recuperação
    $sql = "SELECT * FROM recuperacao_senha WHERE token = '$token' AND usado = 0";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Atualizar a senha do usuário
        $row = $result->fetch_assoc();
        $user_id = $row['usuario_id'];

        // Hash da nova senha
        $nova_senha_hash = password_hash($nova_senha, PASSWORD_BCRYPT);

        // Atualizar a senha na tabela de usuários
        $update_sql = "UPDATE usuarios SET senha = '$nova_senha_hash' WHERE id = $user_id";
        if ($conn->query($update_sql) === TRUE) {
            // Marcar o token como usado
            $update_token_sql = "UPDATE recuperacao_senha SET usado = 1 WHERE token = '$token'";
            $conn->query($update_token_sql);

            echo json_encode(["success" => true, "message" => "Senha alterada com sucesso."]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao atualizar a senha: " . $conn->error]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Token inválido ou já usado."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Dados insuficientes."]);
}

// Fechar a conexão
$conn->close();
?>
