<?php
// reservas.php

header('Content-Type: application/json');

// Inclui o arquivo de configuração para conectar ao banco de dados
require_once 'config.php';

try {
    // Conexão com o banco de dados
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para buscar todas as reservas
    $stmt = $pdo->prepare("SELECT * FROM reservas");
    $stmt->execute();
    $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retorna as reservas em formato JSON
    echo json_encode(['success' => true, 'data' => $reservas]);
} catch (PDOException $e) {
    // Em caso de erro, retorna a mensagem de erro
    echo json_encode(['success' => false, 'message' => 'Erro ao buscar reservas: ' . $e->getMessage()]);
}
