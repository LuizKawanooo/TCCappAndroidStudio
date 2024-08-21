<?php
// Dados de conexão com o banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Conecta ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obtém os dados da requisição PUT
$input = json_decode(file_get_contents("php://input"), true);
$livroId = isset($_GET['id']) ? intval($_GET['id']) : null;
$statusLivros = isset($input['status_livros']) ? intval($input['status_livros']) : null;

if ($livroId !== null && $statusLivros !== null) {
    // Calcula a data de devolução (20 segundos a partir de agora)
    $devolucaoTime = date('Y-m-d H:i:s', strtotime('+20 seconds'));

    // Prepara e executa a query para atualizar o status e a data de devolução
    $stmt = $conn->prepare("UPDATE livros SET status_livros = ?, rental_end_time = ? WHERE id = ?");
    $stmt->bind_param("isi", $statusLivros, $devolucaoTime, $livroId);

    if ($stmt->execute()) {
        echo json_encode([
            "message" => "Status do livro e data de devolução atualizados com sucesso.",
            "rental_end_time" => $devolucaoTime
        ]);
    } else {
        echo json_encode(["error" => "Erro ao atualizar o status do livro e a data de devolução."]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Dados inválidos fornecidos."]);
}

$conn->close();
?>
