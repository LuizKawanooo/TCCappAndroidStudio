<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Dados de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database_name";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Checa a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Recebe e decodifica os dados JSON
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['institution_code']) || !isset($data['email']) || !isset($data['rm']) || !isset($data['password'])) {
    echo json_encode(["status" => "error", "message" => "All fields are required"]);
    exit();
}

$institution_code = $data['institution_code'];
$email = $data['email'];
$rm = $data['rm'];
$password = $data['password'];

// Valida os dados
if (!preg_match("/^[0-9]{3}$/", $institution_code)) {
    echo json_encode(["status" => "error", "message" => "Invalid institution code"]);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match("/@etec\.sp\.gov\.br$/", $email)) {
    echo json_encode(["status" => "error", "message" => "Invalid email"]);
    exit();
}

// Cria um hash da senha
$password_hashed = password_hash($password, PASSWORD_DEFAULT);

// Prepara e executa a consulta SQL
$sql = "INSERT INTO users (institution_code, email, rm, password) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $institution_code, $email, $rm, $password_hashed);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "User registered successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
