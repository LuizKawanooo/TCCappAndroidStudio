<?php
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$id = $_POST['id'];
$titulo = $_POST['titulo'];
$autor = $_POST['autor'];
$ano = $_POST['ano'];
$arquivo = null;
// faz upload de arquivos
if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === UPLOAD_ERR_OK) {
    $arquivo = file_get_contents($_FILES['arquivo']['tmp_name']);
}

if ($arquivo) {
    $sql = "UPDATE artigos SET titulo='$titulo', autor='$autor', ano='$ano', arquivo='$arquivo' WHERE id=$id";
} else {
    $sql = "UPDATE artigos SET titulo='$titulo', autor='$autor', ano='$ano' WHERE id=$id";
}

if ($conn->query($sql) === TRUE) {
    echo "Artigo atualizado com sucesso";
} else {
    echo "Erro ao atualizar artigo: " . $conn->error;
}

$conn->close();
//recarrega a página
header('Location: tcc.php');
?>
                     
