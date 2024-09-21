<?php
// config.php

define('DB_HOST', 'tccappionic-bd.mysql.uhserver.com'); // Host do banco de dados
define('DB_USER', 'ionic_perfil_bd'); // Usuário do banco de dados
define('DB_PASS', '{[UOLluiz2019'); // Senha do banco de dados
define('DB_NAME', 'tccappionic_bd'); // Nome do banco de dados

// Estabelece a conexão com o banco de dados usando PDO
try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    // Configura o PDO para lançar exceções em caso de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Define o charset para evitar problemas de codificação
    $pdo->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    // Retorna erro em formato JSON e encerra o script
    http_response_code(500);
    echo json_encode(['error' => 'Falha na conexão com o banco de dados: ' . $e->getMessage()]);
    exit();
}
?>
