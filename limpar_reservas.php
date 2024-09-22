// <?php
// include 'db.php'; // Incluindo a conexão ao banco de dados

// function limparReservasAntigas($conn) {
//     $sql = "DELETE FROM reservas_computadores WHERE created_at < NOW() - INTERVAL 30 SECOND";
//     if ($conn->query($sql) === TRUE) {
//         return json_encode(['success' => true, 'message' => 'Reservas antigas removidas com sucesso.']);
//     } else {
//         return json_encode(['success' => false, 'message' => 'Erro ao limpar reservas: ' . $conn->error]);
//     }
// }

// header('Content-Type: application/json');
// echo limparReservasAntigas($conn);
// ?>





<?php
// Database connection
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Limpar reservas antigas
$sql = "DELETE FROM reservas_computadores WHERE TIMESTAMPDIFF(SECOND, horario, NOW()) > 30";
if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $conn->error]);
}

$conn->close();
?>
