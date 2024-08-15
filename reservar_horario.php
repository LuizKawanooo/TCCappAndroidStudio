<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(array("error" => "Falha na conexão com o banco de dados: " . $conn->connect_error)));
}

$input = json_decode(file_get_contents('php://input'), true);
$id = $input['id'];
$email = $input['email'];

$reservado_ate = date('Y-m-d H:i:s', strtotime('+30 seconds'));

$sql = "UPDATE reservas_computadores SET status = 'reservado', email = ?, reservado_ate = ? WHERE id = ? AND status = 'disponivel'";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssi', $email, $reservado_ate, $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(array("success" => "Horário reservado com sucesso!"));
} else {
    echo json_encode(array("error" => "Horário já reservado ou inválido."));
}

$stmt->close();
$conn->close();
?>
