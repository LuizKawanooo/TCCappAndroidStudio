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

// Remove as reservas que foram feitas há mais de 1 minuto
$currentTime = date("Y-m-d H:i:s", strtotime("-1 minute"));

$deleteQuery = "DELETE FROM reservas_computadores WHERE horario < ?";
$stmt = $conn->prepare($deleteQuery);
$stmt->bind_param("s", $currentTime);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Reservas antigas removidas.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao remover reservas: ' . $conn->error]);
}

$stmt->close();
$conn->close();
?>
