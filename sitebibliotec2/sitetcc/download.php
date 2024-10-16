<?php
// Conexão com o banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verifica se o ID do artigo foi passado
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT arquivo, titulo FROM artigos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($arquivo, $titulo);

    if ($stmt->fetch()) {
        // Define os headers para o download
        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment; filename=\"" . $titulo . ".pdf\"");
        echo $arquivo;
    } else {
        echo "Arquivo não encontrado.";
    }

    $stmt->close();
} else {
    echo "ID não especificado.";
}

$conn->close();
?>
