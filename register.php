<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include 'db.php';

// Adicione logs para depuração
error_log("POST data: " . print_r($_POST, true));

$cod_instituicao = isset($_POST['institution_code']) ? $_POST['institution_code'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$rm = isset($_POST['rm']) ? $_POST['rm'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Adicione logs para verificar os valores das variáveis
error_log("Cod Instituicao: $cod_instituicao, Email: $email, RM: $rm, Password: $password");

if (empty($cod_instituicao) || empty($email) || empty($rm) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "All fields are required"]);
    exit();
}

if (!preg_match("/^[0-9]{3}$/", $cod_instituicao)) {
    echo json_encode(["status" => "error", "message" => "Invalid institution code"]);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match("/@etec\.sp\.gov\.br$/", $email)) {
    echo json_encode(["status" => "error", "message" => "Invalid email"]);
    exit();
}

$password_hashed = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO registrar_usuarios (cod_instituicao, email, rm, senha) VALUES ('$cod_instituicao', '$email', '$rm', '$password_hashed')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success", "message" => "User registered successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error: " . $sql . "<br>" . $conn->error]);
}

$conn->close();
?>
