<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Conectar ao banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die(json_encode(["error" => "Conexão falhou: " . $conn->connect_error]));
}

// Verificar se o ID foi enviado via GET
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Query para obter a URL do PDF do artigo
    $sql = "SELECT arquivo FROM artigos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($arquivo);
    $stmt->fetch();

    if ($arquivo) {
        $pdf_url = "https://endologic.com.br/tcc/uploads/" . $arquivo;
        echo json_encode(["pdf_url" => $pdf_url]);
    } else {
        echo json_encode(["error" => "Artigo não encontrado."]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "ID do artigo não fornecido."]);
}

$conn->close();
?>
