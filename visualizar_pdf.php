<?php
function verificarToken($id, $token) {
    $chave = 'c@v3b1bl1ot3c_2024!'; // Deve ser a mesma chave secreta usada para gerar o token
    return hash_hmac('sha256', $id, $chave) === $token;
}

$host = 'tccappionic-bd.mysql.uhserver.com';
$user = 'ionic_perfil_bd';
$password = '{[UOLluiz2019';
$database = 'tccappionic_bd';

$mysqli = new mysqli($host, $user, $password, $database);

if ($mysqli->connect_error) {
    die("Falha na conexão: " . $mysqli->connect_error);
}

$id = $_GET['id'];
$token = $_GET['token'];

if (verificarToken($id, $token)) {
    $query = "SELECT arquivo, pdf_name FROM artigos WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($arquivo, $pdf_nome);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        header("Content-Type: application/pdf");
        header("Content-Disposition: inline; filename=\"" . $pdf_nome . "\"");
        echo $arquivo;
    } else {
        echo "PDF não encontrado.";
    }

    $stmt->close();
} else {
    echo "Token inválido.";
}

$mysqli->close();
?>
