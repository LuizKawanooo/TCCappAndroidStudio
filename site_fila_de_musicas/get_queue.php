<?php
header("Access-Control-Allow-Origin: *"); // Permite requisições de qualquer origem
header('Content-Type: application/json');

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT * FROM queue ORDER BY id ASC";
$result = $conn->query($sql);


::contentReference[oaicite:0]{index=0}
 
