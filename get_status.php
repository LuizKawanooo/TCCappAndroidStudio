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

// Conectar ao banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT status_livros, rental_start_time, rental_end_time FROM books WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $status_livros = $row['status_livros'];
    $rental_end_time = $row['rental_end_time'];

    $remaining_time = 0;
    if ($status_livros == 1 && $rental_end_time) {
        $currentTime = new DateTime();
        $rentalEndTime = new DateTime($rental_end_time);
        $interval = $currentTime->diff($rentalEndTime);
        $remaining_time = ($interval->days * 24 * 60 * 60) + ($interval->h * 60 * 60) + ($interval->i * 60) + $interval->s;

        if ($remaining_time <= 0) {
            $status_livros = 0;
            $remaining_time = 0;
        }
    }

    echo json_encode([
        'status_livros' => $status_livros,
        'remaining_time' => $remaining_time
    ]);
} else {
    echo json_encode(['status_livros' => 0, 'remaining_time' => 0]);
}

$conn->close();
?>
