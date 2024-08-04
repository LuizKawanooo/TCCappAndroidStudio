<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch images and status_livro
$sql = "SELECT id, imagem, status_livro FROM livros"; // Supondo que a tabela de imagens tenha colunas 'id', 'imagem' e 'status_livro'
$result = $conn->query($sql);

$images = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $images[] = array(
            "id" => $row["id"],
            "image_url" => 'data:image/jpeg;base64,' . base64_encode($row["imagem"]), // Converter BLOB para base64 e criar uma URL de dados
            "status_livro" => $row["status_livro"]
        );
    }
} else {
    echo json_encode(array("message" => "No images found"));
    $conn->close();
    exit();
}

$conn->close();

echo json_encode(array("images" => $images));
?>
