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

// Verifica a conexão
if ($conn->connect_error) {
    echo json_encode(['message' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

$id = intval($_GET['id']);

// Prepara a consulta
$sql = "SELECT status_livros, rental_end_time FROM livros WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($status_livros, $rental_end_time);
$stmt->fetch();
$stmt->close();

$remaining_time = 0;

if ($status_livros == 1 && $rental_end_time) {
    $currentTime = new DateTime();
    $rentalEndTime = new DateTime($rental_end_time);
    $interval = $currentTime->diff($rentalEndTime);
    $remaining_time = ($interval->s); // Apenas segundos restantes

    // Se o tempo de aluguel expirou
    if ($remaining_time <= 0) {
        $status_livros = 0;  // Define como disponível
        $remaining_time = 0;
    }
}

echo json_encode([
    'status_livros' => $status_livros,
    'remaining_time' => max($remaining_time, 0) // Garantir que o tempo restante não seja negativo
]);

$conn->close();
?>

