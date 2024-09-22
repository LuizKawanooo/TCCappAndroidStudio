<?php
// Configurações de cabeçalhos CORS
header('Access-Control-Allow-Origin: *'); // Permite acesso de qualquer origem
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE'); // Métodos permitidos
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Cabeçalhos permitidos
header('Content-Type: application/json'); // Tipo de conteúdo da resposta

// Conexão com o banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Verifica se foi passado um ID para download
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM artigos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $row['titulo'] . '.pdf"');
        echo $row['arquivo']; // Envia o BLOB do arquivo
        exit(); // Termina a execução após enviar o arquivo
    } else {
        echo json_encode(["error" => "Arquivo não encontrado."]);
        exit();
    }
}

// Consulta SQL para recuperar os artigos cadastrados
$sql = "SELECT * FROM artigos";
$result = $conn->query($sql);

$artigos = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $artigos[] = $row;
    }
}

$conn->close();

echo json_encode($artigos);
?>
