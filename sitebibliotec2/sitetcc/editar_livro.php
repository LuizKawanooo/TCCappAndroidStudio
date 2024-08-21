<?php
// Conexão com o banco de dados
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

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepara os dados para atualização no banco de dados
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
    
    // Inicializa a variável capa
    $capa = NULL;
    
    // Processa o upload da nova capa
    if (isset($_FILES['capa']) && $_FILES['capa']['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['capa']['tmp_name'];
        $name = basename($_FILES['capa']['name']);
        $upload_dir = 'uploads/';
        $upload_file = $upload_dir . $name;
        
        // Cria o diretório de uploads se não existir
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Move o arquivo para o diretório de uploads
        if (move_uploaded_file($tmp_name, $upload_file)) {
            $capa = $upload_file;
        } else {
            echo "Erro ao fazer upload da imagem.";
            exit;
        }
    }

    // Se não houver nova capa, mantenha a capa antiga (caso seja necessário)
    // Para manter a capa antiga, você pode fazer uma consulta para obter o caminho da capa atual.
    // Aqui estou considerando que você já tem o caminho da capa atual.
    $sql = "SELECT capa FROM livro WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($capa_atual);
    $stmt->fetch();
    $stmt->close();

    // Se não houve upload de nova capa, mantenha a capa atual
    if ($capa === NULL) {
        $capa = $capa_atual;
    }

    // Prepara a consulta SQL para atualização
    $sql = "UPDATE livro SET titulo = ?, autor = ?, editora = ?, genero = ?, tombo = ?, ano = ?, classificacao = ?, n_paginas = ?, isbn = ?, capa = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssisi", $titulo, $autor, $editora, $genero, $tombo, $ano, $classificacao, $n_paginas, $isbn, $capa, $id);
    
    if ($stmt->execute()) {
        echo "<center><div class='title'><h2>Livro atualizado com sucesso!</h2></div></center>";
    } else {
        echo "<center><div class='title'><h2>Não foi possível atualizar o livro. Entre em contato com o suporte.</h2></div></center>";
    }

    $stmt->close();
}
$conn->close();
header('Location: livros.php');
?>
