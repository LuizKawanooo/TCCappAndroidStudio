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

// Verifique se os dados foram decodificados corretamente
if (!is_array($data)) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON"]);
    exit();
}

$cod_instituicao = isset($data['institution_code']) ? $data['institution_code'] : '';
$email = isset($data['email']) ? $data['email'] : '';
$rm = isset($data['rm']) ? $data['rm'] : '';
$password = isset($data['password']) ? $data['password'] : '';

// Verifique se todos os campos foram preenchidos
if (empty($cod_instituicao) || empty($email) || empty($rm) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "All fields are required"]);
    exit();
}

// Valide o código da instituição
if (!preg_match("/^[0-9]{3}$/", $cod_instituicao)) {
    echo json_encode(["status" => "error", "message" => "Invalid institution code"]);
    exit();
}

// Valide o e-mail
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match("/@etec\.sp\.gov\.br$/", $email)) {
    echo json_encode(["status" => "error", "message" => "Invalid email"]);
    exit();
}

// Faça o hash da senha
$password_hashed = password_hash($password, PASSWORD_DEFAULT);

// Prepare a consulta SQL
$sql = "INSERT INTO registrar_usuarios (cod_instituicao, email, rm, senha) VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $cod_instituicao, $email, $rm, $password_hashed);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "User registered successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
