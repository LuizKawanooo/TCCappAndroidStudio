<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Conectar ao banco de dados
$host = "tccappionic-bd.mysql.uhserver.com";
$dbname = "tccappionic_bd";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";

// Conecta ao banco de dados
$pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Consulta SQL para obter todos os livros
$query = "SELECT * FROM livro"; // Supondo que a tabela se chama "livros"
$stmt = $pdo->prepare($query);
$stmt->execute();

// Obtém todos os resultados
$livros = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retorna os dados como JSON
echo json_encode($livros);
?>
