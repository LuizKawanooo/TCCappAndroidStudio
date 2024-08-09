// <?php
// header('Content-Type: application/json');
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: POST');
// header('Access-Control-Allow-Headers: Content-Type');

// $servername = "tccappionic-bd.mysql.uhserver.com";
// $username = "ionic_perfil_bd";
// $password = "{[UOLluiz2019";
// $dbname = "tccappionic_bd";

// $conn = new mysqli($servername, $username, $password, $dbname);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// $data = json_decode(file_get_contents('php://input'), true);

// if (isset($data['id']) && isset($data['status'])) {
//     $id = intval($data['id']);
//     $status = intval($data['status']);
    
//     $update_sql = "UPDATE livros SET status_livros = ? WHERE id = ?";
//     $stmt_update = $conn->prepare($update_sql);
//     $stmt_update->bind_param("ii", $status, $id);
    
//     if ($stmt_update->execute()) {
//         echo json_encode(['message' => 'Status updated successfully']);
//     } else {
//         echo json_encode(['message' => 'Failed to update status']);
//     }
    
//     $stmt_update->close();
// } else {
//     echo json_encode(['message' => 'Invalid input']);
// }

// $conn->close();
// ?>















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
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];
$status = $_POST['status'];
$current_time = date('Y-m-d H:i:s');

// Define o tempo final para o aluguel de 30 segundos
if ($status == 1) {
    $rental_end_time = date('Y-m-d H:i:s', strtotime($current_time . ' + 30 seconds'));
} else {
    $rental_end_time = NULL;
}

$sql = "UPDATE livros SET status_livros = ?, rental_end_time = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isi", $status, $rental_end_time, $id);

if ($stmt->execute()) {
    echo json_encode(array("message" => "Status updated successfully"));
} else {
    echo json_encode(array("message" => "Failed to update status"));
}

$stmt->close();
$conn->close();
?>
