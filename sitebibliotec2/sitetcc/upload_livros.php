<?php
// Configurações do banco de dados
$host = 'tccappionic-bd.mysql.uhserver.com';
$db   = 'tccappionic_bd';
$user = 'ionic_perfil_bd';
$pass = '{[UOLluiz2019';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erro na conexão: ' . $e->getMessage());
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta os dados do formulário
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $genero = $_POST['genero'];
    $editora = $_POST['editora'];
    $tombo = $_POST['tombo'];
    $ano = $_POST['ano'];
    $classificacao = $_POST['classificacao'];
    $n_paginas = $_POST['n_paginas'];
    $isbn = $_POST['isbn'];

    // Verifica se a imagem foi enviada
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
        // Lê a imagem e armazena em uma variável
        $imagem = file_get_contents($_FILES['imagem']['tmp_name']);

        // Verifica se o arquivo é uma imagem válida
        $imageFileType = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            header("Location: livros.php?message=Formato de imagem inválido!");
            exit;
        }

        // Prepara a consulta SQL para inserção
        $sqlInsert = "INSERT INTO livros (titulo, autor, genero, editora, tombo, ano, classificacao, n_paginas, isbn, imagem) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtInsert = $pdo->prepare($sqlInsert);
        
        // Tenta executar a inserção
        if ($stmtInsert->execute([$titulo, $autor, $genero, $editora, $tombo, $ano, $classificacao, $n_paginas, $isbn, $imagem])) {
            header("Location: livros.php?message=Livro adicionado com sucesso!");
            exit;
        } else {
            header("Location: livros.php?message=Erro ao armazenar no banco de dados.");
            exit;
        }
    } else {
        header("Location: livros.php?message=Erro no upload da imagem.");
        exit;
    }
}
?>
