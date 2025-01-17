<?php
// Conexão com o banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM queue ORDER BY id ASC");
$queue = [];

while ($row = $result->fetch_assoc()) {
    $queue[] = $row;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Reprodução da Fila</title>
</head>
<body>
    <h1>Reproduzindo
::contentReference[oaicite:0]{index=0}
 
