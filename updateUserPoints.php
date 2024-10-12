<?php
header("Content-Type: application/json");

// Permitir CORS (Cross-Origin Resource Sharing)
header("Access-Control-Allow-Origin: *"); // Permite todas as origens
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Métodos permitidos
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Cabeçalhos permitidos


// Conexão com o banco de dados
$host = "tccappionic-bd.mysql.uhserver.com"; // URL do seu banco de dados
$dbname = "tccappionic_bd"; // Nome do banco de dados
$username = "ionic_perfil_bd"; // Nome de usuário
$password = "{[UOLluiz2019"; // Senha do banco de dados

// Criação da conexão
$conn = new mysqli($host, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Conexão falhou: " . $conn->connect_error]));
}

// Obtendo os dados da requisição
$data = json_decode(file_get_contents("php://input"), true);
$userRM = isset($data['userRM']) ? intval($data['userRM']) : 0;
$updatedPoints = isset($data['pontos']) ? intval($data['pontos']) : 0;

if ($userRM <= 0 || $updatedPoints < 0) {
    echo json_encode(["status" => "error", "message" => "Dados inválidos."]);
    exit;
}

// Atualiza os pontos do usuário
$sql = "UPDATE registrar_usuarios SET pontos = ? WHERE rm = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $updatedPoints, $userRM);
$result = $stmt->execute();

// Verifica se a atualização foi bem-sucedida
if ($result) {
    echo json_encode(["status" => "success", "message" => "Pontos atualizados com sucesso."]);
} else {
    echo json_encode(["status" => "error", "message" => "Erro ao atualizar os pontos."]);
}

// Fechar a conexão
$stmt->close();
$conn->close();
?>
