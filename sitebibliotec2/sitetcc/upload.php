<?php
// upload.php

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
    // Prepara os dados para inserção no banco de dados
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $genero = $_POST['genero'];
    $editora = $_POST['editora'];
    $tombo = $_POST['tombo'];
    $ano = $_POST['ano'];
    $classificacao = $_POST['classificacao'];
    $n_paginas = $_POST['n_paginas'];
    $isbn = $_POST['isbn'];

    // Processa o upload da imagem
    $imagem = NULL;
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['imagem']['tmp_name'];
        $imageData = file_get_contents($tmp_name);

        // Verifica se o arquivo é uma imagem válida
        $fileType = mime_content_type($tmp_name);
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];

        if (in_array($fileType, $allowedTypes)) {
            $imagem = $imageData;
        } else {
            echo "Arquivo não é uma imagem válida. Formatos aceitos: JPEG, PNG, GIF.";
            exit;
        }
    } else {
        echo "Erro no upload da imagem.";
        exit;
    }

    // Prepara a consulta SQL para inserção
    $sql = "INSERT INTO livros (titulo, genero, autor, editora, tombo, ano, classificacao, n_paginas, isbn, imagem) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param(
            "sssssssssb",
            $titulo, $genero, $autor, $editora, $tombo, $ano, $classificacao, $n_paginas, $isbn, $imagem
        );

        // Executa a consulta
        if ($stmt->execute()) {
            echo "<script>window.location.href = 'livros.php';</script>";
        } else {
            echo "Erro ao inserir registro: " . $stmt->error;
        }

        // Fecha a consulta
        $stmt->close();
    } else {
        echo "Erro na preparação da consulta: " . $conn->error;
    }
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
