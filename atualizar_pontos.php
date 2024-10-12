<?php
header('Content-Type: application/json');

// Permitir solicitações de qualquer origem
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Configurações do banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com"; // Nome do servidor
$username = "ionic_perfil_bd"; // Usuário do MySQL
$password = "{[UOLluiz2019"; // Senha do MySQL
$dbname = "tccappionic_bd"; // Nome do banco de dados

// Crie a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifique a conexão
if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Falha na conexão com o banco de dados: ' . $conn->connect_error]));
}

// Função para atualizar os pontos do usuário
function atualizarPontosUsuario($conn, $userRM) {
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
}

// Verifica se o método da requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userRM = isset($_POST['user_rm']) ? intval($_POST['user_rm']) : null;

    if (is_null($userRM)) {
        echo json_encode(['status' => 'error', 'message' => 'RM do usuário não fornecido.']);
        exit;
    }

    // Chama a função para atualizar os pontos
    atualizarPontosUsuario($conn, $userRM);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método não permitido.']);
}

// Fecha a conexão com o banco
$conn->close();
?>
