<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$host = 'tccappionic-bd.mysql.uhserver.com'; // Substitua pelo seu host do banco de dados
$db = 'tccappionic_bd'; // Substitua pelo nome do seu banco de dados
$user = 'ionic_perfil_bd'; // Substitua pelo seu usuário do banco de dados
$pass = '{[UOLluiz2019'; // Substitua pela sua senha do banco de dados

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('Erro de conexão: ' . $conn->connect_error);
}

// Configurações de paginação
$pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$livros_por_pagina = isset($_GET['livros_por_pagina']) ? intval($_GET['livros_por_pagina']) : 4;
$offset = ($pagina - 1) * $livros_por_pagina;

$sql = "SELECT COUNT(*) AS total FROM livro";
$result = $conn->query($sql);
$total = $result->fetch_assoc()['total'];

$sql = "SELECT id, titulo, autor, editora, imagem FROM livro LIMIT $offset, $livros_por_pagina";
$result = $conn->query($sql);

$livros = array();
while ($row = $result->fetch_assoc()) {
    $livros[] = $row;
}

echo json_encode(array(
    'livros' => $livros,
    'pagina_atual' => $pagina,
    'total_paginas' => ceil($total / $livros_por_pagina)
));

$conn->close();
?>
