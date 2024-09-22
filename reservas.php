<?php
// reservas.php

// Permitir o acesso de qualquer origem
header('Access-Control-Allow-Origin: *');
// Permitir métodos HTTP específicos
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
// Permitir cabeçalhos específicos
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Definições do banco de dados
define('DB_HOST', 'tccappionic-bd.mysql.uhserver.com'); // Host do banco de dados
define('DB_USER', 'ionic_perfil_bd'); // Usuário do banco de dados
define('DB_PASS', '{[UOLluiz2019'); // Senha do banco de dados
define('DB_NAME', 'tccappionic_bd'); // Nome do banco de dados

// Conexão com o banco de dados
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Erro de conexão com o servidor. Por favor, tente novamente mais tarde.']);
    exit;
}

// Seleciona todas as reservas ativas
$query = "SELECT * FROM reservas_computadores WHERE status = 'reservado'";
$result = $conn->query($query);

$reservas = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reservas[] = $row;
    }
}

echo json_encode(['success' => true, 'data' => $reservas]);

$conn->close();
?>
