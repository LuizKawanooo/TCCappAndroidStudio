<?php
// Permitir todas as origens (CORS)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require 'database_connection.php'; // Certifique-se de que este arquivo está correto e acessível

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Certifique-se de que as variáveis estão sendo recebidas corretamente
    $user_rm = isset($_POST['user_rm']) ? $_POST['user_rm'] : null;
    $book_id = isset($_POST['book_id']) ? $_POST['book_id'] : null;

    if ($user_rm !== null && $book_id !== null) {
        // Lógica para adicionar o livro à estante
        $query = "INSERT INTO user_bookshelf (user_rm, book_id) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        
        if ($stmt === false) {
            // Se a preparação falhar, mostre o erro
            echo json_encode(["success" => false, "message" => "Erro na preparação da consulta: " . $conn->error]);
            exit();
        }

        $stmt->bind_param("si", $user_rm, $book_id);
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Livro adicionado à estante."]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao adicionar livro: " . $stmt->error]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Dados não recebidos corretamente."]);
    }
} else {
    // Para outros métodos que não são POST
    echo json_encode(["success" => false, "message" => "Método não suportado."]);
}
?>
