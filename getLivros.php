<?php
header('Content-Type: application/json');

$host = "tccappionic-bd.mysql.uhserver.com";
$dbname = "tccappionic_bd";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";

try {
    // Cria uma nova conexão PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepara e executa a consulta SQL
    $stmt = $pdo->prepare("SELECT * FROM livro");
    $stmt->execute();

    // Obtém todos os resultados da consulta
    $livros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retorna os resultados como JSON
    echo json_encode($livros);

} catch (PDOException $e) {
    // Se ocorrer um erro, exibe a mensagem de erro
    echo json_encode(['error' => $e->getMessage()]);
}
?>









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
        'livros' => $livros
    ]);

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
