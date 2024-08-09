// <?php
// header('Content-Type: application/json');
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: GET');
// header('Access-Control-Allow-Headers: Content-Type');

// $servername = "tccappionic-bd.mysql.uhserver.com";
// $username = "ionic_perfil_bd";
// $password = "{[UOLluiz2019";
// $dbname = "tccappionic_bd";

// $conn = new mysqli($servername, $username, $password, $dbname);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// $id = intval($_GET['id']);

// $sql = "SELECT status_livros FROM livros WHERE id = ?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("i", $id);
// $stmt->execute();
// $stmt->bind_result($status_livros);
// $stmt->fetch();
// $stmt->close();

// echo json_encode(['status_livros' => $status_livros]);

// $conn->close();
// ?>







<?php
error_reporting(0); // Suprimir erros PHP durante a execução

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['message' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

$id = intval($_GET['id']);

$sql = "SELECT status_livros, rental_end_time FROM livros WHERE id = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(['message' => 'Prepare failed: ' . $conn->error]);
    exit;
}
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($status_livros, $rental_end_time);
$stmt->fetch();
$stmt->close();

$current_time = new DateTime();
$rental_end = new DateTime($rental_end_time);
$remaining_time = max(0, $rental_end->getTimestamp() - $current_time->getTimestamp());

echo json_encode([
    'status_livros' => $status_livros,
    'remaining_time' => $remaining_time
]);

$conn->close();
?>

