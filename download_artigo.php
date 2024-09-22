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
    $sql = "SELECT * FROM artigos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Definir cabeçalhos para download
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . basename($row['titulo']) . '.pdf"');
            header('Content-Length: ' . strlen($row['arquivo']));

            // Enviar o BLOB do arquivo
            echo $row['arquivo'];
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Arquivo não encontrado."]);
        }
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Erro na consulta ao banco de dados."]);
    }
    exit();
}

$conn->close();
?>
