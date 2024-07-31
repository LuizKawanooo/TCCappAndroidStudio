<?php
header('Content-Type: application/json');

// Configurações de conexão
$host = 'tccappionic-bd.mysql.uhserver.com'; // Endereço do servidor MySQL
$port = '3306'; // Porta padrão do MySQL
$db   = 'tccappionic_bd'; // Nome do banco de dados
$user = 'ionic_perfil_bd'; // Seu usuário
$pass = '{[UOLluiz2019'; // Sua senha

// Parâmetros de paginação
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 4; // Número de livros por página
$offset = ($page - 1) * $limit;

try {
    // Conexão com o banco de dados
    $dsn = "mysql:host=$host;port=$port;dbname=$db";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar se a tabela 'livro' existe
    $tablesStmt = $pdo->query("SHOW TABLES LIKE 'livro'");
    if ($tablesStmt->rowCount() == 0) {
        throw new Exception('Tabela livro não encontrada.');
    }

    // Conta o número total de livros
    $countStmt = $pdo->query("SELECT COUNT(*) FROM livro");
    $totalCount = $countStmt->fetchColumn();

    // Busca os livros para a página atual
    $stmt = $pdo->prepare("SELECT * FROM livro LIMIT :limit OFFSET :offset");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $livros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'totalCount' => $totalCount,
        'livros' => $livros
    ]);

} catch (PDOException $e) {
    // Exibe mensagem de erro se ocorrer um problema com a conexão ou consulta
    echo json_encode(['error' => $e->getMessage()]);
}
?>
