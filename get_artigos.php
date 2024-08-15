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

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']); 

    if ($stmt = $conn->prepare("SELECT pdf_nome, arquivo FROM artigos WHERE id = ?")) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($pdf_nome, $arquivo);
        $stmt->fetch();

        if ($stmt->num_rows > 0) {
            header("Content-Type: application/pdf");
            header("Content-Disposition: inline; filename=\"$pdf_nome\"");
            echo $arquivo;
        } else {
            http_response_code(404);
            echo "Arquivo não encontrado.";
        }

        $stmt->close();
    } else {
        http_response_code(500);
        echo "Erro ao preparar a consulta.";
    }
} else {
    http_response_code(400);
    echo "ID não fornecido ou está vazio.";
}

$conn->close();
?>
