// <?php
// $servername = "tccappionic-bd.mysql.uhserver.com";
// $username = "ionic_perfil_bd";
// $password = "{[UOLluiz2019";
// $dbname = "tccappionic_bd";

// $conn = new mysqli($servername, $username, $password, $dbname);
// if ($conn->connect_error) {
//     die("Erro na conexão: " . $conn->connect_error);
// }

// $id = isset($_POST['id']) ? intval($_POST['id']) : null;
// $titulo = $_POST['titulo'];
// $autor = $_POST['autor'];
// $editora = $_POST['editora'];
// $genero = $_POST['genero'];
// $tombo = $_POST['tombo'];
// $ano = $_POST['ano'];
// $classificacao = $_POST['classificacao'];
// $n_paginas = $_POST['n_paginas'];
// $isbn = $_POST['isbn'];


// $sql = "UPDATE livros SET titulo=?, autor=?, editora=?, genero=?, tombo=?, ano=?, classificacao=?, n_paginas=?, isbn=? WHERE id=?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("ssssiissiib", $titulo, $autor, $editora, $genero, $tombo, $ano, $classificacao, $n_paginas, $isbn, $id);
// $stmt->execute(); 

// $stmt->close();
// $conn->close();

// header("Location: livros.php"); // Redireciona de volta para a lista de livros
// exit();
// ?>















<?php
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Obtém os dados do formulário
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

// Inicializa a variável da imagem
$imagem = null;

// Verifica se uma nova imagem foi enviada
if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
    $imagem = 'uploads/' . basename($_FILES['imagem']['name']);
    // Move o arquivo enviado para a pasta 'uploads'
    if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $imagem)) {
        die("Erro ao fazer upload da imagem.");
    }
} else {
    // Se não houve upload, busca a imagem atual no banco de dados
    $sql = "SELECT imagem FROM livros WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($imagem);
    $stmt->fetch();
    $stmt->close();
}

// Atualiza os dados no banco de dados
$sql = "UPDATE livros SET titulo=?, autor=?, editora=?, genero=?, tombo=?, ano=?, classificacao=?, n_paginas=?, isbn=?, imagem=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssiissibi", $titulo, $autor, $editora, $genero, $tombo, $ano, $classificacao, $n_paginas, $isbn, $imagem, $id);
$stmt->execute();

$stmt->close();
$conn->close();

header("Location: livros.php"); // Redireciona de volta para a lista de livros
exit();
?>
