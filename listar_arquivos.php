<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Configurações do banco de dados
$host = "tccappionic-bd.mysql.uhserver.com";
$dbname = "tccappionic_bd";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";

try {
    // Cria uma conexão com o banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepara e executa a consulta SQL
    $sql = "SELECT id, titulo, pdf_nome FROM artigos";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Recupera todos os registros
    $artigos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Verifica se há artigos e retorna como JSON
    if ($artigos) {
        echo json_encode($artigos);
    } else {
        echo json_encode(['message' => 'Nenhum artigo encontrado.']);
    }
} catch (PDOException $e) {
    // Retorna erro em formato JSON
    echo json_encode(['error' => 'Erro ao consultar o banco de dados: ' . $e->getMessage()]);
}
?>
