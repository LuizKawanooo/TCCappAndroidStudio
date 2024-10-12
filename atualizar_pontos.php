<?php
header('Content-Type: application/json');
include 'config.php'; // Inclua seu arquivo de configuração de banco de dados

function conectarAoBanco() {
    global $dbHost, $dbUser, $dbPass, $dbName;
    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    if ($conn->connect_error) {
        die(json_encode(['status' => 'error', 'message' => 'Falha na conexão com o banco de dados: ' . $conn->connect_error]));
    }
    return $conn;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userRM = isset($_POST['user_rm']) ? intval($_POST['user_rm']) : null;

    if (is_null($userRM)) {
        echo json_encode(['status' => 'error', 'message' => 'RM do usuário não fornecido.']);
        exit;
    }

    $conn = conectarAoBanco();

    // Atualiza os pontos do usuário
    $sqlAtualizarUsuario = "UPDATE usuarios SET pontos = pontos + 100 WHERE rm = ?";
    $stmt = $conn->prepare($sqlAtualizarUsuario);
    $stmt->bind_param('i', $userRM);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Pontos atualizados com sucesso!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar os pontos: ' . $conn->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método não permitido.']);
}
?>
