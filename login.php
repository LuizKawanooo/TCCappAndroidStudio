<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include 'db.php';

// Adicione logs para depuração
error_log("POST data: " . print_r($_POST, true));

$rm = isset($_POST['rm']) ? $_POST['rm'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Adicione logs para verificar os valores das variáveis
error_log("RM: $rm, Password: $password");

if (empty($rm) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "All fields are required"]);
    exit();
}

$sql = "SELECT * FROM registrar_usuarios WHERE rm = '$rm'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['senha'])) {
        echo json_encode(["status" => "success", "message" => "Login successful"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid password"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "User not found"]);
}

$conn->close();
?>
