<?php
header("Content-Type: application/json");

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

// Obtendo o RM do usuário da requisição
$userRM = isset($_GET['userRM']) ? intval($_GET['userRM']) : 0;

if ($userRM <= 0) {
    echo json_encode(["status" => "error", "message" => "RM do usuário inválido."]);
    exit;
}

// Consulta para obter os pontos do usuário
$sql = "SELECT pontos FROM registrar_usuarios WHERE rm = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userRM);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se o usuário existe
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(["status" => "success", "data" => ["pontos" => $row['pontos']]]);
} else {
    echo json_encode(["status" => "error", "message" => "Usuário não encontrado."]);
}

// Fechar a conexão
$stmt->close();
$conn->close();
?>
