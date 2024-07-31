<?php
header('Content-Type: application/json');

$host = 'tccappionic-bd.mysql.uhserver.com'; // Seu host
$db   = 'tccappionic_bd'; // Nome do banco de dados
$user = 'ionic_perfil_bd'; // Seu usuário
$pass = '{[UOLluiz2019'; // Sua senha






// Parâmetros de paginação
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 4; // Número de livros por página
$offset = ($page - 1) * $limit;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Conta o número total de livros
    $countStmt = $pdo->query("SELECT COUNT(*) FROM livro");
    $totalCount = $countStmt->fetchColumn();

    // Busca os livros para a página atual
    $stmt = $pdo->prepare("SELECT * FROM livros LIMIT :limit OFFSET :offset");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $livros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'totalCount' => $totalCount,
        'livro' => $livros
    ]);

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
