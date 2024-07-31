<?php
header('Content-Type: application/json');

$host = 'localhost'; // Seu host
$db   = 'tccappionic_bd'; // Nome do banco de dados
$user = 'seu_usuario'; // Seu usuário
$pass = 'sua_senha'; // Sua senha

// Parâmetros de paginação
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 4; // Número de livros por página
$offset = ($page - 1) * $limit;

try {
    // Conexão com o banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar se a tabela 'livros' existe
    $tablesStmt = $pdo->query("SHOW TABLES LIKE 'livros'");
    if ($tablesStmt->rowCount() == 0) {
        throw new Exception('Tabela livros não encontrada.');
    }

    // Conta o número total de livros
    $countStmt = $pdo->query("SELECT COUNT(*) FROM livros");
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

} catch (Exception $e) {
    // Exibe mensagem de erro se ocorrer um problema com a conexão ou consulta
    echo json_encode(['error' => $e->getMessage()]);
}
?>
