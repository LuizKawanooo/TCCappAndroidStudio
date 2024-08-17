<?php
function gerarToken($id) {
    $chave = 'c@v3b1bl1ot3c_2024!'; // Deve ser uma chave secreta conhecida apenas pelo seu servidor
    return hash_hmac('sha256', $id, $chave);
}

$host = 'tccappionic-bd.mysql.uhserver.com';
$user = 'ionic_perfil_bd';
$password = '{[UOLluiz2019';
$database = 'tccappionic_bd';

$mysqli = new mysqli($host, $user, $password, $database);

if ($mysqli->connect_error) {
    die("Falha na conexão: " . $mysqli->connect_error);
}

$id = $_GET['id']; // ID do PDF a ser visualizado
$token = gerarToken($id); // Função definida acima

$query = "SELECT titulo FROM artigos WHERE id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($titulo);
$stmt->fetch();

if ($stmt->num_rows > 0) {
    echo '<h1>' . htmlspecialchars($titulo) . '</h1>';
    echo '<a href="visualizar_pdf.php?id=' . $id . '&token=' . urlencode($token) . '" target="_blank">Ver PDF</a>';
} else {
    echo "PDF não encontrado.";
}

$stmt->close();
$mysqli->close();
?>
