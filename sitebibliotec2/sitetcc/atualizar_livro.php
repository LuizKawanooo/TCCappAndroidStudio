<?php
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$id = isset($_POST['id']) ? intval($_POST['id']) : null;
$titulo = $_POST['titulo'];
$autor = $_POST['autor'];
$editora = $_POST['editora'];
$genero = $_POST['genero'];
$tombo = $_POST['tombo'];
$ano = $_POST['ano'];
$classificacao = $_POST['classificacao'];
$n_paginas = $_POST['n_paginas'];
$isbn = $_POST['isbn'];


$sql = "UPDATE livros SET titulo=?, autor=?, editora=?, genero=?, tombo=?, ano=?, classificacao=?, n_paginas=?, isbn=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssiissiib", $titulo, $autor, $editora, $genero, $tombo, $ano, $classificacao, $n_paginas, $isbn, $id);
$stmt->execute(); 

$stmt->close();
$conn->close();

header("Location: livros.php"); // Redireciona de volta para a lista de livros
exit();
?>
