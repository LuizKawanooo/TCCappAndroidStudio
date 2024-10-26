<?php
$servername = "tccappionic-bd.mysql.uhserver.com"; // por exemplo, "localhost"
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Criar conexão
$connection = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($connection->connect_error) {
    die("Erro na conexão: " . $connection->connect_error);
}
?>

