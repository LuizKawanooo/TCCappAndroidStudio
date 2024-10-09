// <?php
// // Conexão com o banco de dados
// $servername = "tccappionic-bd.mysql.uhserver.com";
// $username = "ionic_perfil_bd";
// $password = "{[UOLluiz2019";
// $dbname = "tccappionic_bd";

// // Cria a conexão
// $conn = new mysqli($servername, $username, $password, $dbname);

// // Verifica a conexão
// if ($conn->connect_error) {
//     die("Erro na conexão: " . $conn->connect_error);
// }

// // Verifica se o formulário foi enviado
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // Prepara os dados para atualização no banco de dados
//     $id = $_POST['id'];
//     $titulo = $_POST['titulo'];
//     $autor = $_POST['autor'];
//     $editora = $_POST['editora'];
//     $genero = $_POST['genero'];
//     $tombo = $_POST['tombo'];
//     $ano = $_POST['ano'];
//     $classificacao = $_POST['classificacao'];
//     $n_paginas = $_POST['n_paginas'];
//     $isbn = $_POST['isbn'];
    
//     // Inicializa a variável imagem
//     $imagem = NULL;
    
//     // Processa o upload da nova imagem
//     if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
//         $tmp_name = $_FILES['imagem']['tmp_name'];
//         $name = basename($_FILES['imagem']['name']);
//         $upload_dir = 'uploads/';
//         $upload_file = $upload_dir . $name;
        
//         // Cria o diretório de uploads se não existir
//         if (!file_exists($upload_dir)) {
//             mkdir($upload_dir, 0777, true);
//         }

//         // Move o arquivo para o diretório de uploads
//         if (move_uploaded_file($tmp_name, $upload_file)) {
//             $imagem = $upload_file;
//         } else {
//             echo "Erro ao fazer upload da imagem.";
//             exit;
//         }
//     }

//     // Se não houver nova imagem, mantenha a imagem antiga (caso seja necessário)
//     // Para manter a imagem antiga, você pode fazer uma consulta para obter o caminho da imagem atual.
//     // Aqui estou considerando que você já tem o caminho da imagem atual.
//     $sql = "SELECT imagem FROM livros WHERE id = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("i", $id);
//     $stmt->execute();
//     $stmt->bind_result($imagem_atual);
//     $stmt->fetch();
//     $stmt->close();

//     // Se não houve upload de nova imagem, mantenha a imagem atual
//     if ($imagem === NULL) {
//         $imagem = $imagem_atual;
//     }

//     // Prepara a consulta SQL para atualização
//     $sql = "UPDATE livros SET titulo = ?, autor = ?, editora = ?, genero = ?, tombo = ?, ano = ?, classificacao = ?, n_paginas = ?, isbn = ?, imagem = ? WHERE id = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("ssssssssisi", $titulo, $autor, $editora, $genero, $tombo, $ano, $classificacao, $n_paginas, $isbn, $imagem, $id);
    
//     if ($stmt->execute()) {
//         echo "<center><div class='title'><h2>Livro atualizado com sucesso!</h2></div></center>";
//     } else {
//         echo "<center><div class='title'><h2>Não foi possível atualizar o livro. Entre em contato com o suporte.</h2></div></center>";
//     }

//     $stmt->close();
// }
// $conn->close();
// header('Location: livros.php');
// ?>





















<?php
// editar_livro.php
header('Content-Type: application/json');

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

// Coleta os dados do formulário
$id = $_POST['id'];
$titulo = $_POST['titulo'];
$autor = $_POST['autor'];
$editora = $_POST['editora'];
$genero = $_POST['genero'];
$tombo = $_POST['tombo'];
$ano = $_POST['ano'];
$classificacao = $_POST['classificacao'];
$n_paginas = $_POST['n_paginas'];
$isbn = $_POST['isbn'];
$imagem = null;

// Verifica se uma nova imagem foi enviada
if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
    $imagem = file_get_contents($_FILES['imagem']['tmp_name']);
}

// Prepara a consulta SQL para atualização
$sql = "UPDATE livros SET titulo=?, autor=?, editora=?, genero=?, tombo=?, ano=?, classificacao=?, n_paginas=?, isbn=?, imagem=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssisssi", $titulo, $autor, $editora, $genero, $tombo, $ano, $classificacao, $n_paginas, $isbn, $imagem, $id);

// Tenta executar a atualização
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Livro atualizado com sucesso!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar o livro.']);
}

$stmt->close();
$conn->close();
?>
