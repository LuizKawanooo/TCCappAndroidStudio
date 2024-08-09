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
header('Access-Control-Allow-Origin: *'); // Permite solicitações de qualquer origem
header('Access-Control-Allow-Methods: POST'); // Permite apenas o método POST
header('Access-Control-Allow-Headers: Content-Type');

// Conectar ao banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    echo json_encode(['message' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

// Verificar se a entrada JSON é válida
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['message' => 'Invalid JSON input']);
    $conn->close();
    exit;
}

// Verificar se os dados esperados estão presentes
if (isset($data['id']) && isset($data['status'])) {
    $id = intval($data['id']);
    $status = intval($data['status']);
    
    if ($status === 1) {
        $rental_end_time = date('Y-m-d H:i:s', time() + 30); // Define o tempo de expiração para 30 segundos no futuro
        $update_sql = "UPDATE livros SET status_livros = ?, rental_end_time = ? WHERE id = ?";
        $stmt_update = $conn->prepare($update_sql);
        if ($stmt_update === false) {
            echo json_encode(['message' => 'Prepare failed: ' . $conn->error]);
            $conn->close();
            exit;
        }
        $stmt_update->bind_param("isi", $status, $rental_end_time, $id);
    } else {
        $update_sql = "UPDATE livros SET status_livros = ?, rental_end_time = NULL WHERE id = ?";
        $stmt_update = $conn->prepare($update_sql);
        if ($stmt_update === false) {
            echo json_encode(['message' => 'Prepare failed: ' . $conn->error]);
            $conn->close();
            exit;
        }
        $stmt_update->bind_param("ii", $status, $id);
    }
    
    if ($stmt_update->execute()) {
        echo json_encode(['message' => 'Status updated successfully']);
    } else {
        echo json_encode(['message' => 'Failed to update status']);
    }
    
    $stmt_update->close();
} else {
    echo json_encode(['message' => 'Invalid input']);
}

$conn->close();
?>

