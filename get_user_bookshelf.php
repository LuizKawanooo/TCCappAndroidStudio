<?php

// Permitir todas as origens (CORS)
header("Access-Control-Allow-Origin: *");
// Permitir métodos específicos, se necessário (GET, POST, OPTIONS, etc.)
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// Permitir cabeçalhos específicos
header("Access-Control-Allow-Headers: Content-Type");


require 'database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $user_rm = $_GET['user_rm'];

    // Consulta para buscar os livros na estante do usuário
    $query = "SELECT l.* 
              FROM livros l
              INNER JOIN estante_usuario e ON l.id = e.book_id
              WHERE e.user_rm = ?";
              
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $user_rm);
    $stmt->execute();
    $result = $stmt->get_result();

    $books = [];
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
    
    echo json_encode(["success" => true, "books" => $books]);
}
?>
