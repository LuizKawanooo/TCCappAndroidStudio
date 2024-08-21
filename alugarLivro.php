<?php
header('Content-Type: application/json');

// Permitir CORS
header('Access-Control-Allow-Origin: *'); // Permite todas as origens
header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); // Métodos permitidos
header('Access-Control-Allow-Headers: Content-Type'); // Cabeçalhos permitidos

// Conexão com o banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019"; // Verifique se a senha está correta e não possui caracteres especiais não escapados
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
$data_aluguel = isset($data['data_aluguel']) ? intval($data['data_aluguel']) : 0;

// Verificar se o livro está disponível para aluguel
$sql = "SELECT status_livros FROM livros WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['status_livros'] == 0) {
        // Atualizar status do livro e definir data do aluguel
        $sql = "UPDATE livros SET status_livros = 1, data_aluguel = $data_aluguel WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["success" => true, "message" => "Livro alugado com sucesso"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao atualizar livro: " . $conn->error]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Livro já está alugado"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Livro não encontrado"]);
}

$conn->close();
?>
