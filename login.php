<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

include 'db.php'; // Inclua o arquivo de conexão com o banco de dados

// Verifique se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit();
}

// Obtenha os dados da requisição
$data = json_decode(file_get_contents('php://input'), true);

$rm = isset($data['rm']) ? $data['rm'] : '';
$password = isset($data['password']) ? $data['password'] : '';

// Verifique se os dados foram preenchidos
if (empty($rm) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "All fields are required"]);
    exit();
}

// Prepare a consulta SQL
$sql = "SELECT senha FROM registrar_usuarios WHERE rm = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $rm);
$stmt->execute();
$stmt->bind_result($password_hashed);
$stmt->fetch();
$stmt->close();

// Verifique a senha
if (password_verify($password, $password_hashed)) {
    echo json_encode(["status" => "success", "message" => "Login successful"]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid RM or password"]);
}

$conn->close();
?>
