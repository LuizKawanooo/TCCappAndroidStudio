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
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifique a conexão
if ($conn->connect_error) {
    die(json_encode(['message' => 'Connection failed: ' . $conn->connect_error]));
}

$id = intval($_GET['id']);

$sql = "SELECT status_livros, rental_start_time FROM livros WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    // Exiba o erro se a preparação falhar
    die(json_encode(['message' => 'Prepare failed: ' . $conn->error]));
}

$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($status_livros, $rental_start_time);
$stmt->fetch();
$stmt->close();

$response = [
    'status_livros' => $status_livros,
    'rental_start_time' => $rental_start_time
];

echo json_encode($response);

$conn->close();
?>
