<?php
function resetPassword($token, $new_password) {
    $conn = new mysqli("seu_host", "seu_usuario", "sua_senha", "meu_banco_de_dados");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT id FROM registrar_usuarios WHERE reset_token = ? AND reset_token_expiry > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE registrar_usuarios SET senha = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?");
        $stmt->bind_param("si", $hashed_password, $user["id"]);
        $stmt->execute();
    }

    $stmt->close();
    $conn->close();

    return $user != null;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST["token"];
    $new_password = $_POST["new_password"];
    if (resetPassword($token, $new_password)) {
        echo json_encode(["message" => "Senha resetada com sucesso!"]);
    } else {
        echo json_encode(["message" => "Token inválido ou expirado!"]);
    }
}
?>
