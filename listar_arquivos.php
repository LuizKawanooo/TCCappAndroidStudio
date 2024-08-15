<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Configurações do banco de dados
$dsn = 'mysql:host=tccappionic-bd.mysql.uhserver.com;dbname=tccappionic_bd';
$username = 'ionic_perfil_bd';
$password = '{[UOLluiz2019';

// Criar conexão com o banco de dados
try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Preparar a consulta SQL
    $sql = "SELECT id, titulo, descricao, pdf_nome FROM artigos";
    $stmt = $pdo->query($sql);

    // Verificar se a consulta foi bem-sucedida
    if ($stmt === false) {
        echo json_encode(array("error" => "Erro na consulta: " . $pdo->errorInfo()[2]));
        exit();
    }

    // Recuperar os resultados
    $artigos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retornar os dados como JSON
    echo json_encode(array("artigos" => $artigos));
} catch (PDOException $e) {
    echo json_encode(array("error" => "Erro: " . $e->getMessage()));
}

// Fechar a conexão
$pdo = null;
?>
