<?php
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
} catch (PDOException $e) {
    echo json_encode(array("error" => "Conexão falhou: " . $e->getMessage()));
    exit();
}

// Preparar e executar a consulta SQL
$sql = "SELECT id, titulo, descricao, pdf_nome FROM artigos";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $artigos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(array("artigos" => $artigos));
} catch (PDOException $e) {
    echo json_encode(array("error" => "Erro na consulta: " . $e->getMessage()));
}

// Fechar a conexão
$pdo = null;
?>
