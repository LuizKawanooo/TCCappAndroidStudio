<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$servername = "tccappionic-bd.mysql.uhserver.com"; // ou o endereço do seu servidor
$username = "ionic_perfil_bd"; // seu nome de usuário
$password = "{[UOLluiz2019"; // sua senha
$dbname = "tccappionic_bd";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ler horários
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $conn->query("SELECT * FROM horarios");
    $horarios = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($horarios);
    exit;
}

// Atualizar status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $horario = $data['horario'];
    $status = $data['status'];
    
    if (isset($horario) && isset($status)) {
        $stmt = $conn->prepare("UPDATE horarios SET status = ? WHERE horario = ?");
        $stmt->bind_param("is", $status, $horario);
        $stmt->execute();
        echo json_encode(["success" => true]);
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Invalid input"]);
    }
    exit;
}

$conn->close();
?>
