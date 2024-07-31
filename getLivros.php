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
