<?php
$servername = "tccappionic-bd.mysql.uhserver.com"; // Ou o nome do seu servidor
$username = "ionic_perfil_bd"; // Seu usuário do MySQL
$password = "{[UOLluiz2019"; // Sua senha do MySQL
$dbname = "tccappionic_bd"; // Nome do seu banco de dados

// Crie a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifique a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
