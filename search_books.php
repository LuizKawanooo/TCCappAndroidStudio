<?php
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$searchTerm = isset($_GET['q']) ? $_GET['q'] : '';

if ($searchTerm) {
    $searchTerm = $conn->real_escape_string($searchTerm);
    $sql = "SELECT * FROM livros WHERE titulo LIKE '%$searchTerm%' OR autor LIKE '%$searchTerm%'";
    $result = $conn->query($sql);

    $books = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
    }

    echo json_encode($books);
} else {
    echo json_encode([]);
}

$conn->close();
?>
