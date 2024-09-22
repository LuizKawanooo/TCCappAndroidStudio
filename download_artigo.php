<?php
// Configurações de cabeçalhos CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Content-Type: application/pdf');

// Conexão com o banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Rota para download do PDF
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT titulo, arquivo FROM artigos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $filePath = $row['arquivo'];

        // Verifica se o arquivo existe
        if (file_exists($filePath)) {
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
            exit();
        } else {
            echo json_encode(["error" => "Arquivo não encontrado."]);
        }
    } else {
        echo json_encode(["error" => "Arquivo não encontrado."]);
    }
} else {
    echo json_encode(["error" => "ID não fornecido."]);
}

$conn->close();
?>
