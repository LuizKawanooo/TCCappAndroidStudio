// Em PHP, por exemplo:
<?php
require 'database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_rm = $_POST['user_rm'];
    $book_id = $_POST['book_id'];

    $query = "INSERT INTO user_bookshelf (user_rm, book_id) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $user_rm, $book_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Livro adicionado à estante com sucesso."]);
    } else {
        echo json_encode(["success" => false, "message" => "Erro ao adicionar o livro."]);
    }
}
?>
