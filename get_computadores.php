<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

define('DB_HOST', 'tccappionic-bd.mysql.uhserver.com');
define('DB_USER', 'ionic_perfil_bd');
define('DB_PASS', '{[UOLluiz2019');
define('DB_NAME', 'tccappionic_bd');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Erro de conexão: ' . $conn->connect_error]);
    exit;
}

// Busca todos os computadores
$computadores = [];
$queryComputadores = "SELECT id FROM computadores"; // Ajuste se necessário
$resultComputadores = $conn->query($queryComputadores);

while ($row = $resultComputadores->fetch_assoc()) {
    $idComputador = $row['id'];
    
    // Busca as reservas para este computador
    $reservas = [];
    $queryReservas = "SELECT horario FROM reservas_computadores WHERE computador_id = ?";
    $stmt = $conn->prepare($queryReservas);
    $stmt->bind_param("i", $idComputador);
    $stmt->execute();
    $resultReservas = $stmt->get_result();

    while ($reserva = $resultReservas->fetch_assoc()) {
        $reservas[] = $reserva['horario'];
    }
    
    $computadores[] = [
        'id' => $idComputador,
        'reservas' => $reservas
    ];
}

$stmt->close();
$conn->close();

echo json_encode(['success' => true, 'data' => $computadores]);
