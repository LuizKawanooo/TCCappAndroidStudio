<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(array("error" => "Falha na conexão com o banco de dados: " . $conn->connect_error)));
}

$data = date('Y-m-d');
$now = date('Y-m-d H:i:s');

$sql = "UPDATE reservas_computadores SET status = 'disponivel', email = NULL, reservado_ate = NULL WHERE reservado_ate <= ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $now);
$stmt->execute();

$sql = "SELECT id, horario, status FROM reservas_computadores WHERE data = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $data);
$stmt->execute();
$result = $stmt->get_result();

$horarios = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $horarios[] = $row;
    }
    echo json_encode(array("horarios" => $horarios));
} else {
    echo json_encode(array("horarios" => []));
}

$stmt->close();
$conn->close();
?>
