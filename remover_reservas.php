<?php
// remover_reservas.php

// Definições do banco de dados
define('DB_HOST', 'tccappionic-bd.mysql.uhserver.com');
define('DB_USER', 'ionic_perfil_bd');
define('DB_PASS', '{[UOLluiz2019');
define('DB_NAME', 'tccappionic_bd');

// Conexão com o banco de dados
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verifica a conexão
if ($conn->connect_error) {
    error_log("Erro de conexão: " . $conn->connect_error);
    exit;
}

// Seleciona e remove todas as reservas que expiraram (mais de 30 segundos atrás)
$query = "DELETE FROM reservas_computadores WHERE rental_end_time <= NOW() AND status = 'reservado'";
if ($conn->query($query) === TRUE) {
    echo "Reservas expiradas removidas com sucesso.";
} else {
    error_log("Erro ao remover reservas expiradas: " . $conn->error);
}

// Fecha a conexão
$conn->close();
?>
