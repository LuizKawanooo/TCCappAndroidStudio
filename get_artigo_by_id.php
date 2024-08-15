<?php
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

    // Consulta para buscar o artigo específico
    $stmt = $conn->prepare("SELECT pdf_nome, arquivo FROM artigos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($pdf_nome, $arquivo);
    $stmt->fetch();

    if ($pdf_nome && $arquivo) {
        // Configura o cabeçalho para o tipo de conteúdo PDF
        header("Content-Type: application/pdf");
        header("Content-Disposition: inline; filename=\"$pdf_nome\"");
        echo $arquivo;
    } else {
        echo "Arquivo não encontrado.";
    }

    $stmt->close();
} else {
    echo "ID não fornecido.";
}

$conn->close();
?>
