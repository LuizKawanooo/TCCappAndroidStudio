<?php
header('Content-Type: application/json');

$host = 'tccappionic-bd.mysql.uhserver.com';
$db   = 'tccappionic_bd';
$user = 'ionic_perfil_bd';
$pass = '{[UOLluiz2019';

try {
    // Conectar ao banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Preparar a consulta
    $stmt = $pdo->prepare('SELECT id, pdf_url FROM artigos');
    $stmt->execute();

    // Obter os resultados
    $artigos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retornar os resultados como JSON
    echo json_encode($artigos);
} catch (PDOException $e) {
    // Em caso de erro, retornar uma mensagem de erro
    echo json_encode(['error' => $e->getMessage()]);
}
?>
