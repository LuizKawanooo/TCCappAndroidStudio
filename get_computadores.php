<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

define('DB_HOST', 'tccappionic-bd.mysql.uhserver.com');
define('DB_USER', 'ionic_perfil_bd');
define('DB_PASS', '{[UOLluiz2019');
define('DB_NAME', 'tccappionic_bd');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Erro de conexão: ' . $conn->connect_error]);
    exit;
}

$query = "SELECT computador_id, status FROM reservas_computadores";
$result = $conn->query($query);

$computadores = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $disponibilidade = $row['status'] === 'reservado' ? 'Reservado' : 'Disponível';
        $computadores[] = ['id' => $row['computador_id'], 'disponibilidade' => $disponibilidade];
    }
}

echo json_encode(['success' => true, 'data' => $computadores]);
$conn->close();
?>
