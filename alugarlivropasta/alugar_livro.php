<?php
header("Access-Control-Allow-Origin: *"); // Permite todas as origens
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Permite métodos HTTP
header("Access-Control-Allow-Headers: Content-Type"); // Permite cabeçalhos específicos


header('Content-Type: application/json');

$host = 'tccappionic-bd.mysql.uhserver.com';
$dbname = 'tccappionic_bd';
$username = 'ionic_perfil_bd';
$password = '{[UOLluiz2019';



try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Recebe o ID do livro
    $input = json_decode(file_get_contents('php://input'), true);
    $id = $input['id'];

    // Verifica o status atual do livro
    $stmt = $pdo->prepare("SELECT status_livros FROM livros WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($book && $book['status_livros'] == 0) {
        // Atualiza o status do livro para 1 (alugado)
        $stmt = $pdo->prepare("UPDATE livros SET status_livros = 1, rental_start_time = NOW(), rental_end_time = DATE_ADD(NOW(), INTERVAL 30 SECOND) WHERE id = :id");
        $stmt->execute(['id' => $id]);

        echo json_encode(['success' => true, 'message' => 'Livro alugado com sucesso!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'O livro já está alugado ou não existe.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
}
