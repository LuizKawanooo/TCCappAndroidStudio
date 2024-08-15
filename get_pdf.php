<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/pdf");
header("Content-Disposition: inline; filename=artigo.pdf");

// Habilitar exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conectar ao banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se o ID foi enviado via GET
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Query para obter o PDF do artigo
    $sql = "SELECT arquivo FROM artigos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($arquivo);
    $stmt->fetch();

    if ($arquivo) {
        // Definir o tipo de conteúdo e exibir o PDF
        header("Content-Type: application/pdf");
        echo $arquivo;
    } else {
        echo "Artigo não encontrado.";
    }

    $stmt->close();
} else {
    echo "ID do artigo não fornecido.";
}

$conn->close();
?>
