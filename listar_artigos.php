<?php
header("Access-Control-Allow-Origin: *"); // Permite requisições de qualquer origem
header("Content-Type: application/json; charset=UTF-8");

// Configurações do banco de dados
$host = "tccappionic-bd.mysql.uhserver.com";
$dbname = "tccappionic_bd";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";

// Conectar ao banco de dados
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    // Consulta SQL para buscar todos os artigos
    $sql = "SELECT id, titulo, descricao, pdf_nome, data_publicacao FROM artigos";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    // Recupera todos os artigos
    $artigos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Retorna os dados no formato JSON
    echo json_encode($artigos);
} catch (PDOException $e) {
    // Em caso de erro, retorna uma mensagem de erro
    echo json_encode(array("message" => "Erro ao consultar o banco de dados."));
}
    echo $sql;
?>
