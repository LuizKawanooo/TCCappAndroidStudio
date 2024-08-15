<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");



$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT pdf_nome, arquivo FROM artigos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($pdf_nome, $arquivo);
    $stmt->fetch();

    // Define o tipo de conteúdo como PDF
    header("Content-Type: application/pdf");
    header("Content-Disposition: inline; filename=\"$pdf_nome\"");
    header("Content-Length: " . strlen($arquivo));

    // Exibe o conteúdo PDF
    echo $arquivo;

    $stmt->close();
}

$conn->close();
?>
