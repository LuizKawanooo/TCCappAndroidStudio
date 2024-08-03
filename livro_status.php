<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept');

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, imagem, livro_status_disponivel, livro_status_alugado FROM livros";
$result = $conn->query($sql);

$images = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Define o livro_status com base nas condições
        $livro_status = 'ALUGADO'; // Valor padrão
        if (!empty($row['livro_status_disponivel']) && empty($row['livro_status_alugado'])) {
            $livro_status = 'DISPONÍVEL';
        }

        $images[] = [
            'id' => $row['id'],
            'image_url' => 'data:image/jpeg;base64,' . base64_encode($row['imagem']),
            'livro_status' => $livro_status
        ];
    }
}

echo json_encode($images);

$conn->close();
?>
