<?php
// Configurações de cabeçalhos CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json');

// Conexão com o banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com"; // Nome do servidor
$username = "ionic_perfil_bd"; // Usuário do MySQL
$password = "{[UOLluiz2019"; // Senha do MySQL
$dbname = "tccappionic_bd"; // Nome do banco de dados

// Crie a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifique a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Recebe o token e a nova senha
$data = json_decode(file_get_contents("php://input"));
$token = $data->token;
$novaSenha = password_hash($data->novaSenha, PASSWORD_BCRYPT);

// Verifica se o token existe
$query = $conn->prepare("SELECT id FROM registrar_usuarios WHERE token = ?");
$query->bind_param("s", $token);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user_id = $user['id'];

    // Atualiza a senha e limpa o token
    $stmt = $conn->prepare("UPDATE registrar_usuarios SET senha = ?, token = NULL WHERE id = ?");
    $stmt->bind_param("si", $novaSenha, $user_id);
    $stmt->execute();

    echo json_encode(["success" => true, "message" => "Senha redefinida com sucesso."]);
} else {
    echo json_encode(["success" => false, "message" => "Token inválido."]);
}

$conn->close();
?>
