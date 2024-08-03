<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept');

// Configurações do banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta SQL para selecionar imagens e status
$sql = "SELECT id, imagem, imagem_status, imagem_tipo FROM livros"; // Inclua o campo imagem_tipo
$result = $conn->query($sql);

$images = [];

// Processa os resultados da consulta
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Define o tipo MIME baseado no tipo da imagem
        $mimeType = 'image/jpeg'; // Default to JPEG
        if ($row['imagem_tipo'] === 'image/png') {
            $mimeType = 'image/png';
        } elseif ($row['imagem_tipo'] === 'image/jpeg') {
            $mimeType = 'image/jpeg';
        }

        // Codifica a imagem em base64 e inclui o tipo MIME no URL
        $images[] = [
            'id' => $row['id'],
            'image_url' => 'data:' . $mimeType . ';base64,' . base64_encode($row['imagem']),
            'status' => $row['imagem_status'] // Inclua o imagem_status
        ];
    }
} else {
    // Se não houver resultados, retorne uma matriz vazia
    echo json_encode([]);
    exit();
}

// Retorna os resultados no formato JSON
echo json_encode($images);

$conn->close();
?>
