<?php
header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON
header('Access-Control-Allow-Origin: *'); // Permite acesso de qualquer origem (CORS)

// Configurações de conexão com o banco de dados
$host = 'tccappionic-bd.mysql.uhserver.com'; // Substitua pelo seu host do banco de dados
$db = 'tccappionic_bd'; // Substitua pelo nome do seu banco de dados
$user = 'ionic_perfil_bd'; // Substitua pelo seu usuário do banco de dados
$pass = '{[UOLluiz2019'; // Substitua pela sua senha do banco de dados

// Conecta ao banco de dados
$conn = new mysqli($host, $user, $pass, $db);

// Verifica se houve um erro na conexão
if ($conn->connect_error) {
    die('Erro de conexão: ' . $conn->connect_error);
}

// Define a consulta SQL para obter todos os livros
$sql = "SELECT * FROM livro";
$result = $conn->query($sql);

// Verifica se há resultados
if ($result->num_rows > 0) {
    // Cria um array para armazenar os livros
    $livros = array();

    // Itera pelos resultados e adiciona cada livro ao array
    while ($row = $result->fetch_assoc()) {
        $livros[] = $row;
    }

    // Converte o array de livros para JSON e imprime
    echo json_encode($livros);
} else {
    // Se não houver resultados, retorna um array vazio
    echo json_encode(array());
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
