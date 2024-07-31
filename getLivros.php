<?php
header('Content-Type: application/json');

// Configurações do banco de dados
$host = 'tccappionic-bd.mysql.uhserver.com'; // Seu host
$db   = 'tccappionic_bd'; // Nome do banco de dados
$user = 'ionic_perfil_bd'; // Seu usuário
$pass = '{[UOLluiz2019'; // Sua senha

try {
    // Conectar ao banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obter o número da página a partir da URL
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 4; // Número de livros por página
    $offset = ($page - 1) * $limit;

    // Consultar o total de livros
    $totalQuery = $pdo->query("SELECT COUNT(*) as totalCount FROM livro");
    $totalResult = $totalQuery->fetch(PDO::FETCH_ASSOC);
    $totalCount = $totalResult['totalCount'];

    // Consultar os livros para a página atual
    $query = $pdo->prepare("SELECT * FROM livro LIMIT :limit OFFSET :offset");
    $query->bindParam(':limit', $limit, PDO::PARAM_INT);
    $query->bindParam(':offset', $offset, PDO::PARAM_INT);
    $query->execute();

    $livros = $query->fetchAll(PDO::FETCH_ASSOC);

    // Retornar os dados no formato JSON
    echo json_encode([
        'livros' => $livros,
        'totalCount' => $totalCount
    ]);
} catch (PDOException $e) {
    // Retornar erro em formato JSON
    echo json_encode(['error' => $e->getMessage()]);
}
