<?php
header("Access-Control-Allow-Origin: *"); // Permite todas as origens
header("Access-Control-Allow-Methods: POST"); // Permite métodos HTTP
header("Access-Control-Allow-Headers: Content-Type"); // Permite cabeçalhos específicos
header('Content-Type: application/json');

// Conexão com o banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Conexão falhou: " . $conn->connect_error]);
    exit();
}

// Receber dados da requisição
$data = json_decode(file_get_contents("php://input"), true);
$id = isset($data['id']) ? intval($data['id']) : 0;

// Validar ID do livro
if ($id <= 0) {
    echo json_encode(["success" => false, "message" => "ID inválido"]);
    $conn->close();
    exit();
}

// Preparar e executar a atualização da data de devolução
$data_devolucao = date('Y-m-d H:i:s', strtotime('+20 seconds')); // Define a data de devolução como 20 segundos a partir de agora

// Verifique se a tabela e o campo existem
if ($stmt = $conn->prepare("UPDATE livros SET data_devolucao = ? WHERE id = ?")) {
    $stmt->bind_param("si", $data_devolucao, $id);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Data de devolução atualizada com sucesso"]);
    } else {
        echo json_encode(["success" => false, "message" => "Erro ao atualizar data de devolução: " . $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Erro ao preparar a consulta: " . $conn->error]);
}

$conn->close();
?>
