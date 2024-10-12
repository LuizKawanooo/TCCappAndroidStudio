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
// Configurações do banco de dados
$host = 'tccappionic-bd.mysql.uhserver.com';
$db   = 'tccappionic_bd';
$user = 'ionic_perfil_bd';
$pass = '{[UOLluiz2019';
$charset = 'utf8mb4';

// Configuração do DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    // Conexão com o banco de dados usando PDO
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erro na conexão: ' . $e->getMessage());
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Inicializa a variável imagem com a imagem atual
    $imagem = null;

    // Verifica se uma nova imagem foi enviada
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
        // Lê a imagem e armazena em uma variável
        $imagem = file_get_contents($_FILES['imagem']['tmp_name']);
    } else {
        // Se não houver nova imagem, busca a imagem atual no banco de dados
        $sql = "SELECT imagem FROM livros WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $livroAtual = $stmt->fetch(PDO::FETCH_ASSOC);
        $imagem = $livroAtual['imagem']; // Manter a imagem atual
    }

    // Prepara a consulta SQL para atualização
    $sqlUpdate = "UPDATE livros SET titulo=?, autor=?, genero=?, editora=?, tombo=?, ano=?, classificacao=?, n_paginas=?, isbn=?, imagem=? WHERE id=?";
    $stmtUpdate = $pdo->prepare($sqlUpdate);

    // Tenta executar a atualização
    if ($stmtUpdate->execute([$titulo, $autor, $genero, $editora, $tombo, $ano, $classificacao, $n_paginas, $isbn, $imagem, $id])) {
        // Redireciona de volta com uma mensagem de sucesso
        header("Location: livros.php?message=Livro atualizado com sucesso!");
        exit;
    } else {
        // Redireciona de volta com uma mensagem de erro
        header("Location: livros.php?message=Erro ao atualizar no banco de dados.");
        exit;
    }
}
?>
