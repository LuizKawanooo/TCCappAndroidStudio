<?php
// reservas.php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');


// Definições do banco de dados
define('DB_HOST', 'tccappionic-bd.mysql.uhserver.com');
define('DB_USER', 'ionic_perfil_bd');
define('DB_PASS', '{[UOLluiz2019');
define('DB_NAME', 'tccappionic_bd');

// Conexão com o banco de dados
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verifica a conexão
if (!$conn) {
    die(json_encode(['success' => false, 'message' => 'Falha na conexão: ' . mysqli_connect_error()]));
}

// Consulta para buscar todas as reservas
$sql = "SELECT * FROM reservas_computadores";
$result = mysqli_query($conn, $sql);

$reservas = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $reservas[] = $row;
    }
    echo json_encode(['success' => true, 'data' => $reservas]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao buscar reservas: ' . mysqli_error($conn)]);
}

// Fecha a conexão
mysqli_close($conn);
