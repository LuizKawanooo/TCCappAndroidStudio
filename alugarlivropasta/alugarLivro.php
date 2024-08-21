<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Configurações de banco de dados
$host = 'tccappionic-bd.mysql.uhserver.com';
$db = 'tccappionic_bd';
$user = 'ionic_perfil_bd';
$pass = '{[UOLluiz2019';

$conn = new mysqli($host, $user, $pass, $db);

// Verifica a conexão com o banco de dados
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]));
}

// Recebe os dados do POST
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['id']) || !isset($input['data_aluguel'])) {
    echo json_encode(['success' => false, 'message' => 'ID ou data de aluguel ausentes']);
    exit();
}

$id = $input['id'];
$data_aluguel = $input['data_aluguel'];
$data_devolucao = $data_aluguel + 20000; // 20 segundos a mais

// Atualiza o livro no banco de dados
$sql = "UPDATE livros SET data_aluguel = FROM_UNIXTIME(?), data_devolucao = FROM_UNIXTIME(?) WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('iii', $data_aluguel, $data_devolucao, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Livro alugado com sucesso']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao alugar livro: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
