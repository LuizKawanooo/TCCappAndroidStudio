<?php
header("Content-Type: application/json");

// Configurações do banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Cria conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta SQL para obter os livros
$sql = "SELECT id, titulo, autor, imagem FROM livros";
$result = $conn->query($sql);

$livros = array();

if ($result->num_rows > 0) {
    // Adiciona cada linha do resultado ao array
    while($row = $result->fetch_assoc()) {
        $livros[] = $row;
    }
}

// Converte o array para JSON e imprime
echo json_encode($livros);

// Fecha a conexão
$conn->close();
?>
