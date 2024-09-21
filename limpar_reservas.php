<?php
// Conexão com o banco de dados
define('DB_HOST', 'tccappionic-bd.mysql.uhserver.com');
define('DB_USER', 'ionic_perfil_bd');
define('DB_PASS', '{[UOLluiz2019');
define('DB_NAME', 'tccappionic_bd');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die('Erro de conexão: ' . $conn->connect_error);
}

// Obtem a data e hora atual
$currentTime = date("Y-m-d H:i:s");

// Atualiza as reservas que foram feitas há mais de 30 segundos
$updateQuery = "UPDATE reservas_computadores SET aluno_nome = '', email_contato = '', horario = '', computador_id = NULL 
                WHERE TIMESTAMPDIFF(SECOND, horario, ?) > 30";

$stmt = $conn->prepare($updateQuery);
$stmt->bind_param("s", $currentTime);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Reservas limpas com sucesso.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao limpar reservas: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
