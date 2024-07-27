<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Dados de conexão com o banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com"; // Ou o nome do seu servidor
$username = "ionic_perfil_bd"; // Seu usuário do MySQL
$password = "{[UOLluiz2019"; // Sua senha do MySQL
$dbname = "tccappionic_bd"; // Nome do seu banco de dados

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Checa a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Recebe e decodifica os dados JSON
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['rm']) || !isset($data['password'])) {
    echo json_encode(["status" => "error", "message" => "All fields are required"]);
    exit();
}

$rm = $data['rm'];
$password = $data['password'];

// Prepara e executa a consulta SQL
$sql = "SELECT password FROM registrar_usuarios WHERE rm = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $rm);
$stmt->execute();
$stmt->bind_result($password_hashed);
$stmt->fetch();

if (password_verify($password, $password_hashed)) {
    echo json_encode(["status" => "success", "message" => "Login successful"]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid RM or password"]);
}

$stmt->close();
$conn->close();
?>
