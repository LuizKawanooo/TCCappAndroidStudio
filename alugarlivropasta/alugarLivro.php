<?php
header("Access-Control-Allow-Origin: *"); // Permite todas as origens
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Permite métodos HTTP
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

// Preparar e executar a consulta para verificar o status do livro
$stmt = $conn->prepare("SELECT status_livros FROM livros WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['status_livros'] == 0) {
        // Preparar e executar a atualização do status do livro
        $stmt = $conn->prepare("UPDATE livros SET status_livros = 1 WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Livro alugado com sucesso"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao atualizar livro: " . $stmt->error]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Livro já está alugado"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Livro não encontrado"]);
}

$stmt->close();
$conn->close();
?>
