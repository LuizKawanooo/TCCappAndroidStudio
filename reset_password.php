<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "db_username";
$password = "db_password";
$dbname = "db_name";

// Cria conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);
$token = $data['token'];
$new_password = password_hash($data['password'], PASSWORD_DEFAULT);

// Verifica se o token é válido e ainda não expirou
$sql = "SELECT id FROM users WHERE reset_token = ? AND reset_token_expiry > NOW()";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Atualiza a senha do usuário
    $update_sql = "UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ss", $new_password, $token);
    $update_stmt->execute();

    echo json_encode(["message" => "Senha redefinida com sucesso"]);
} else {
    echo json_encode(["error" => "Token inválido ou expirado"]);
}

$stmt->close();
$conn->close();
?>
