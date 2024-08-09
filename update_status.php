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
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id']) && isset($data['status'])) {
    $id = intval($data['id']);
    $status = intval($data['status']);
    
    // Verifique o status atual do livro
    $check_sql = "SELECT status_livros FROM livros WHERE id = ?";
    $stmt_check = $conn->prepare($check_sql);
    $stmt_check->bind_param("i", $id);
    $stmt_check->execute();
    $result = $stmt_check->get_result();
    
    if ($result->num_rows > 0) {
        $current_status = $result->fetch_assoc()['status_livros'];
        
        if ($current_status === '0' && $status === 1) {
            // Atualizar para alugado
            $update_sql = "UPDATE livros SET status_livros = ? WHERE id = ?";
            $stmt_update = $conn->prepare($update_sql);
            $stmt_update->bind_param("ii", $status, $id);
            if ($stmt_update->execute()) {
                echo json_encode(['message' => 'Book rented successfully']);
            } else {
                echo json_encode(['message' => 'Failed to rent book']);
            }
            $stmt_update->close();
        } elseif ($current_status === '1' && $status === 0) {
            // Atualizar para disponível
            $update_sql = "UPDATE livros SET status_livros = ? WHERE id = ?";
            $stmt_update = $conn->prepare($update_sql);
            $stmt_update->bind_param("ii", $status, $id);
            if ($stmt_update->execute()) {
                echo json_encode(['message' => 'Book returned successfully']);
            } else {
                echo json_encode(['message' => 'Failed to return book']);
            }
            $stmt_update->close();
        } else {
            echo json_encode(['message' => 'Book status is already as requested']);
        }
    } else {
        echo json_encode(['message' => 'Book not found']);
    }

    $stmt_check->close();
} else {
    echo json_encode(['message' => 'Invalid input']);
}

$conn->close();
?>
