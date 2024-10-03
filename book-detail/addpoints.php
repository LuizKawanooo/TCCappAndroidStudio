<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die(json_encode(array("status" => "error", "message" => "Falha na conexão: " . $conn->connect_error)));
}

// Recebe dados enviados no corpo da requisição
$data = json_decode(file_get_contents("php://input"), true);
var_dump($data); // Para verificar o que foi recebido

// Obtem o RM do usuário
$userRM = isset($data['userRM']) ? $data['userRM'] : '';

$pointsToAdd = 100;

// Valida dados
if (empty($userRM) || $pointsToAdd <= 0) {
    echo json_encode(array("status" => "error", "message" => "Dados inválidos."));
    $conn->close();
    exit();
}

// Atualiza os pontos do usuário
$sql = "UPDATE registrar_usuarios SET pontos = pontos + ? WHERE rm = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $pointsToAdd, $userRM); // Mudou o tipo para "is" para aceitar string (RM)

if ($stmt->execute()) {
    echo json_encode(array("status" => "success", "message" => "Pontos adicionados com sucesso."));
} else {
    echo json_encode(array("status" => "error", "message" => "Erro ao adicionar pontos."));
}

$stmt->close();
$conn->close();
?>
