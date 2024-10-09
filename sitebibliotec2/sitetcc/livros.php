<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliotec - Livros</title>
    <link rel="shortcut icon" href="img/logo.png">
    
</head>
<body>

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap');
 
            body{
            background-image: linear-gradient(to right, #30cfd0 0%, #330867 100%);
            overflow-y: scroll;
            overflow-x: hidden;

            }
            * {
                margin: 0 auto;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Open Sans', sans-serif;
            }
            .footer {
            width: 101vw;
            height:50vh;
            position: absolute;
            bottom: -10%;
            left: 0;
            fill: #ffffff;
            position: fixed;
            }

            #img{
            position: absolute;
            padding-left: 7px;
            padding-top: 3px;
            }


        

            #menu-h ul {
                max-width: 610px;
                list-style: none;
                padding: 0;
                
            }
            
            #menu-h ul li {
                display: inline;
                
            }
            
            #menu-h ul li a {
                color: #FFF;
                padding: 20px;
                display: inline-block;
                text-decoration: none;
                transition: background .4s;
                
            }
            
            #menu-h ul li a:hover {
                background-color: #30cfd0;
            }

            #menu-sair ul {
                max-width: 520px;
                list-style: none;
                padding: 0;
                
            }
            
            #menu-sair ul li {
                display: inline;
                
            }
            
            #menu-sair ul li a {
                position: absolute;
                left: 96%;
                top: 0%;
                color: #FFF;
                padding: 20px;
                
                text-decoration: none;
                transition: background .4s;
                
            }
            
            #menu-sair ul li a:hover {
                background-color: #f00;
            }
            
            
            .gen{
                justify-content: center;
                align-items: center;
                text-align: center;
                position: absolute;
                background-color: rgb(0, 0, 0,0.4);
                backdrop-filter: blur(10px);
                font-weight: bold;
                width: 20vw;
                height: 100vh;
                padding-top: 10px;
                color: #fff;
                box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                position: fixed;
            
            }

                .container {
                    padding: 20px;
                    display: flex;
                    flex-wrap: wrap; /* Permite que os itens quebrem para a linha seguinte */
                    width: 70vw;
                    height: 50vh;
                    position: absolute;
                    top: 55%;
                    left: 60%;
                    transform: translate(-50%, -50%);
                    align-items: center;
                    gap: 10px; /* Adiciona espaço entre os itens */
                    
                }

                            
                    /* Estilo para telas de 900px ou menores */
                @media (max-width: 900px) {
                    .container {
                        flex-direction: column; /* Alinha os itens verticalmente */
                        width: 90vw; /* Ajusta a largura para se adaptar à tela menor */
                        height: auto; /* Permite que a altura se ajuste ao conteúdo */
                        top: 50%; /* Ajusta a posição vertical */
                        left: 50%; /* Ajusta a posição horizontal */
                        transform: translate(-50%, -50%); /* Mantém o alinhamento central */
                        margin-bottom: 100px;
                    }
                    
                }


            .livro {
                background-color: #fff;
                height: 400px;
                width: 300px;
                justify-content: center;
                font-size: 11px;
                text-align: left;
                align-items: center;
                display: grid;
                padding-top: 30px;
                color: #252527;
                -webkit-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                -moz-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
            }
            
            
            .principal{
                width: 100vw;
                height: 100vh;  
                display: fixed;
            
            }
            
            #btn1 {
                font-family: Roboto, sans-serif;
                font-weight: 0;
                font-size: 14px;
                color: #fff;
                background-color: #30cfd0;
                padding: 10px 30px;
                border: none;
                -webkit-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                -moz-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                border-radius: 50px;
                display: flex;
                flex-direction: row;
                align-items: center;
                cursor: pointer;
                position: absolute;
                top: 79%;
            }
            
            .btn1:hover{
                padding: 10px 28px;
                border: none;
            }
            
            .generos{
                justify-content: center;
                align-items: center;
                font-size: 20px;
                display: flex;
                text-align: center;
                height: 90px;
                margin-bottom: 10px;
                margin-top: 30px;
                
            }
            .generos:hover{
                background-color: #30cfd0;
                text-decoration: none;
                transition: background .5s;
            }
            
            #status{
                
                color: green;
                text-align: center;
            }
            
            .imagem{
                width: 100px;
                position: absolute;
                display: flex;
                top: 15%;
            }
            .adicionar-livro-btn{
                width: 120px;
                font-family: Roboto, sans-serif;
                font-size: 14px;
                color: #fff;
                background-color: #10B007;
                padding: 10px 30px;
                border: none;
                -webkit-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                -moz-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                border-radius: 50px;
                display: flex;
                flex-direction: row;
                align-items: center;
                cursor: pointer;
                position: relative;
                top: 160px;
                left: 13%;
                transform: translate(-50%,-50%);
                z-index: 0;
            }
            
            .barra-de-pesquisa {
                display: flex;
                width: 900px;
                position: absolute;
                left: 37%;
                top: 14%;
            }
            
            .barra-de-pesquisa input[type="text"] {
                flex: 1;
                width: 700px;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px ;
            }
            
            .barra-de-pesquisa button {
                padding: 10px 20px;
                background-color: #005aeb;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }
            
            .barra-de-pesquisa button:hover {
                background-color: #0010eb;
            }
            .barra-de-pesquisa input[type="text"]:focus {
                outline: none;
            }
            
            
            .popup {
                padding-top: 600px;
                display: none; /* Por padrão, o pop-up estará oculto */
                position: fixed; /* Posicionamento fixo para que o pop-up fique no mesmo lugar ao rolar a página */
                top: 10%;
                left: 50%;
                transform: translate(-50%,-50%);
                width: 200%; /* Preencher toda a largura */
                height: 280%; /* Preencher toda a altura */
                background-color: rgba(0,0,0,0.5); /* Fundo escuro semi-transparente */
                background: linear-gradient(to bottom, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0.2) 95%, rgba(0,0,0,0) 100%);
                 z-index: 500;
                
                
            }
            .popupe {
                margin-top: 70px;
                padding-top: 500px;
                display: none; /* Por padrão, o pop-up estará oculto */
                position: fixed; /* Posicionamento fixo para que o pop-up fique no mesmo lugar ao rolar a página */
                top: 10%;
                left: 50%;
                transform: translate(-50%,-50%);
                width: 100%; /* Preencher toda a largura */
                height: 210%; /* Preencher toda a altura */
                background-color: rgba(0,0,0,0.5); /* Fundo escuro semi-transparente */
                position: fixed;
                 z-index: 500;
            }
            
            
            .close {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
                display: flex;
                width: 20px;
                height: 20px;
                position: absolute;
                left: 90%;
                top: 2%;
            }
            
            .close:hover,
            .close:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
            }

            .closee {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
                display: flex;
                width: 20px;
                height: 20px;
                position: absolute;
                left: 90%;
                top: 2%;
            }
            
            .closee:hover,
            .closee:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
            }
            
            .table{
                display: grid;
                justify-content: center;
                border-radius: 10px;
                position: absolute;
                top: -7%;
                left: 34%;
                z-index: 500;
                background-color: #D9D9D9;
                margin: 20% auto; /* Centralizar verticalmente e deixar uma margem de 25% em cima e em baixo */
                padding: 20px;  
                width: 17%; /* Largura do pop-up */
                
            }
            .tablee{
                display: grid;
                justify-content: center;
                border-radius: 10px;
                z-index: 500;
                position: absolute;
                top: -7%;
                left: 34%;
                background-color: #D9D9D9;
                margin: 20% auto; /* Centralizar verticalmente e deixar uma margem de 25% em cima e em baixo */
                padding: 20px;  
                width: 17%; /* Largura do pop-up */
            }
            
            .table close{
                padding-left: 100px;
            
            }
            .inp{
                height: 30px;
                width: 300px;
                flex: 1;
                padding-left: 5px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }
            .inpd{
                height: 30px;
                width: 150px;
                flex: 1;
                padding-left: 5px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }
            #data{
                border: none;
                border-radius: 2px;
            }
            .btn2{
                font-family: Roboto, sans-serif;
                color: #fff;
                background-color: #005aeb;
                padding: 10px 30px;
                border: none;
                -webkit-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                -moz-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                border-radius: 50px;
                display: flex;
                flex-direction: row;
                align-items: center;
                cursor: pointer;
                margin-top: 30px;
                top: 79%;
            }
            .btn3{
                font-family: Roboto, sans-serif;
                color: #fff;
                padding: 10px 30px;
                border: none;
                -webkit-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                -moz-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                border-radius: 50px;
                display: flex;
                flex-direction: row;
                align-items: center;
                cursor: pointer;
                margin-top: 30px;   
                font-size: 12px;
            }
            
            
            .btn4 {
                font-family: Roboto, sans-serif;
                color: #fff;
                padding: 10px 30px;
                border: none;
                box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                border-radius: 50px;
                cursor: pointer;
                font-size: 13px;
                margin-top: 10px;
                display: inline-block;
            }
            .btn3 {
                background-color: #005aeb;
            }
            .btn4 {
                background-color: #3BC020;
                margin-left: 10px; /* Espaço entre os botões */
            }
            .btns{
                width: 350px;
                height: 100px;
                display: inline;
                padding-left: 61.3px;
            }
            .btn4:active {
                background-color: #f00; /* Cor quando o botão está sendo clicado */
            }

            #input:focus{
                outline: none;
            }
            .livros-container {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); /* Cria colunas responsivas */
            }
            
            .quebrar-linha {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* Quebra a linha e ajusta o número de colunas conforme necessário */
            }

            .btn-disponivel {
                background-color: #0f0; /* Verde para disponível */
            }

            .btn-alugado {
                background-color: #f00; /* Vermelho para alugado */
            }
            .btn-excluir {
                font-family: Roboto, sans-serif;
                color: #fff;
                background-color: #f00;
                padding: 10px 30px;
                border: none;
                -webkit-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                -moz-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                border-radius: 50px;
                display: flex;
                flex-direction: row;
                align-items: center;
                cursor: pointer;
                margin-top: 30px;
                font-size: 12px;
            }

            .btn-excluir:hover {
                background-color: #c00;
            }
            .botoes{
                display: flex;
                width: 250px;
                font-size: 10px;
            }

  
        </style>


    

<div class="footer">
        <svg viewBox="0 0 869 344" xmlns="http://www.w3.org/2000/svg">
            <path d="M 272 0.0130308C 164.8 1.21303 46 85.1797 0 127.013L 0 342.013L 867 342.013L 867 6.51303C 779 0.013031 684.5 127.013 616.5 127.013C 548.5 127.013 406 -1.48697 272 0.0130308Z"/>
        </svg>
    </div>

    <div class="gen">
        <h1>GÊNEROS</h1>
        
        <div class="generos" data-genero="Infantil">Infantil</div>
        <div class="generos" data-genero="Ficção">Ficção</div>
        <div class="generos" data-genero="Romance">Romance</div>
        <div class="generos" data-genero="Drama">Drama</div>
        <div class="generos" data-genero="Suspense">Suspense</div>
        <div class="generos" data-genero="Terror">Terror</div>
        <div class="generos" data-genero="Quadrinhos">Quadrinhos</div>
    </div>

    
    <nav id="menu-h">
        <ul>
            <li><a href="inicio.php">Início</a></li>
            <li><a href="livros.php">Livros</a></li>
            <li><a href="ranking.php">Ranking</a></li>
            <li><a href="computadores.php">Computadores</a></li>
            <li><a href="tcc.php">TCC</a></li>
            <li><a href="contato.html">Contato</a></li>
        </ul>
    </nav>
    
    <nav id="menu-sair">
        <ul>
            <li><a href="login.php">Sair</a></li>
        </ul>
    </nav>


<div class="container" id="livros-container">
    <!-- Livros serão adicionados aqui -->

</div>

<div class="adicionar-livro-btn" id="adicionar-livro-btn">
    Adicionar
</div>




<div class="barra-de-pesquisa">
    <form id="search-form" action="livros.php" method="GET">
        <input type="text" name="search" placeholder="Pesquisar...">
        <button type="submit">Pesquisar</button>
    </form>
</div>










    
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

// Verifica se o formulário de pesquisa foi enviado
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Consulta SQL para recuperar os livros cadastrados
if ($search) {
    $sql = "SELECT * FROM livros WHERE titulo LIKE '%$search%' OR autor LIKE '%$search%' OR genero LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM livros";
}

$result = $conn->query($sql);

// Verifica se a consulta retornou algum resultado
if ($result) {
    if ($result->num_rows > 0) {
        echo "<div class='container'>";
        while ($row = $result->fetch_assoc()) {
            echo "<div class='livro'>";
            if ($row["imagem"]) {
                // echo "<img src='image.php?id=" . $row["id"] . "' alt='imagem do livro' style='max-width: 130px; max-height: 150px;'>";
                        echo '<div>
                                <img src="data:image/jpeg;base64,' . base64_encode($row['imagem']) . '" style="max-width: 130px; max-height: 150px; object-fit: contain;">
                              </div>';
            }
            echo "<center><h1>" . $row["titulo"] . "</h1></center>";

            // Verifica o status do livro e exibe a mensagem apropriada
            if ($row["status_livros"] == 0) {
                echo "<h2 style='color: green;'>Livro disponível</h2>";
            } elseif ($row["status_livros"] == 1) {
                echo "<h2 style='color: red;'>Livro alugado</h2>";
            }

            echo "<div class='botoes'>";
            // echo "<div class='btn3' data-id='" . $row["id"] . "'>Editar</div>";
            echo "<div class='btn3' data-id='" . $row['id'] . "'>Editar</div>";
            echo "<div class='btn-excluir' data-id='" . $row["id"] . "'>Excluir</div>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p style='color:#fff; font-size:40px; position: absolute; top: 51%; left: 60%; transform:translate(-50%, -50%);'>Nenhum Livro Encontrado</p>";
    }
} else {
    echo "Erro na consulta: " . $conn->error;
}

$conn->close();
?>


    
//============================================================================================================================================================================================//

<div id="popup" class="popup">
    <div class="table">
        <h1>Adicionar livro</h1>
        <form action="upload_livros.php" method="post" enctype="multipart/form-data"> <!-- Atualizado para enviar para upload.php -->
            <label for="titulo">Título:</label><br>
            <input type="text" id="livro-nome" name="titulo" class="inp" required><br>
            <label for="autor">Autor:</label><br>
            <input type="text" id="livro-autor" name="autor" class="inp" required><br>
            <label for="editora">Edição:</label><br>
            <input type="text" id="editora" name="editora" class="inp" required><br>
            <label for="genero">Gênero:</label><br>
            <input type="text" id="genero" name="genero" class="inp" required><br>
            <label for="tombo">Tombo:</label><br>
            <input type="text" id="tombo" name="tombo" class="inp" required><br>
            <label for="ano">Data:</label><br>
            <input type="date" id="data" name="ano" class="inpd" required><br>
            <label for="classificacao">Classificação:</label><br>
            <input type="text" id="classificacao" name="classificacao" class="inp" required><br>
            <label for="n_paginas">Número de Páginas:</label><br>
            <input type="number" id="n_paginas" name="n_paginas" min="1" class="inp" required><br>
            <label for="isbn">ISBN:</label><br>
            <input type="text" id="isbn" name="isbn" class="inp" required><br>
            <br>
            <input type="file" id="livro-imagem" name="imagem" accept="image/*" required>
            <br>
            <input type="submit" value="Enviar" class="btn2">
        </form>
        <span class="close" onclick="closePopup()">&times;</span>
    </div>
</div>




<div id="popup-editar" class="popup">
    <div class="tablee">
        <h1>Editar livro</h1>
        <form id="editar-form" action="editar_livro.php" method="post" enctype="multipart/form-data">
            <!-- Campos do formulário -->
            <input type="hidden" id="editar-id" name="id">
            <label for="editar-titulo">Título:</label><br>
            <input type="text" id="editar-titulo" name="titulo" class="inp"><br>
            <label for="editar-autor">Autor:</label><br>
            <input type="text" id="editar-autor" name="autor" class="inp"><br>
            <label for="editar-editora">Edição:</label><br>
            <input type="text" id="editar-editora" name="editora" class="inp"><br>
            <label for="editar-genero">Gênero:</label><br>
            <input type="text" id="editar-genero" name="genero" class="inp"><br>
            <label for="editar-tombo">Tombo:</label><br>
            <input type="text" id="editar-tombo" name="tombo" class="inp"><br>
            <label for="editar-ano">Data:</label><br>
            <input type="date" id="editar-ano" name="ano" class="inpd"><br>
            <label for="editar-classificacao">Classificação:</label><br>
            <input type="text" id="editar-classificacao" name="classificacao" class="inp"><br>
            <label for="editar-n_paginas">Número de Páginas:</label><br>
            <input type="number" id="editar-n_paginas" name="n_paginas" min="1" class="inp"><br>
            <label for="editar-isbn">ISBN:</label><br>
            <input type="text" id="editar-isbn" name="isbn" class="inp"><br>
            <br>
            <input type="file" id="livro-imagem" name="imagem" accept="image/*">
    
            <br>
            <input type="submit" value="Salvar" class="btn2">
        </form>
        <span class="closee" onclick="closePopupEditar  ()">&times;</span>
    </div>
</div>



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
        // Exibe a mensagem de erro se a preparação da consulta falhar
        echo "Erro na preparação da consulta: " . $conn->error;
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
}
?>



<!-- <?php
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

        // Verifica se o arquivo é uma imagem JPEG
        $fileType = mime_content_type($tmp_name);
        if ($fileType == 'image/jpeg') {
            $imagem = $imageData;
        } else {
            echo "Arquivo não é uma imagem JPEG.";
            exit;
        }
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
        // Exibe a mensagem de erro se a preparação da consulta falhar
        echo "Erro na preparação da consulta: " . $conn->error;
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
}
?> -->

//============================================================================================================================================================================================//


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

// Recebe a solicitação do cliente
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['id']) && isset($input['novoStatus'])) {
    $id = $conn->real_escape_string($input['id']);
    $novoStatus = $conn->real_escape_string($input['novoStatus']);

    // Verifica se o novoStatus é um valor válido
    $validStatuses = ['Disponível', 'Alugado'];
    if (in_array($novoStatus, $validStatuses)) {
        // Prepara a consulta SQL para atualizar o status
        $sql = "UPDATE livros SET status='$novoStatus' WHERE id='$id'";

        if ($conn->query($sql) === TRUE) {
            echo "";
        } else {
            echo "";
        }
    } else {
        echo "";
    }
} else {
    echo "";
}

// Fecha a conexão com o banco de dados
$conn->close();
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-excluir').forEach(button => {
        button.addEventListener('click', function() {
            const livroId = this.getAttribute('data-id');
            
            if (confirm('Tem certeza de que deseja excluir este livro?')) {
                fetch('excluir_livro.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: livroId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Recarrega a página após a exclusão
                        window.location.reload();
                    } else {
                        alert('Erro ao excluir o livro: ' + (data.error || 'Desconhecido'));
                    }
                })
                .catch(error => console.error('Erro ao excluir o livro:', error));
            }
        });
    });
});


</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const botoesAlterarStatus = document.querySelectorAll('.btn-alterar-status');

    botoesAlterarStatus.forEach(botao => {
        botao.addEventListener('click', function() {
            const livroId = this.getAttribute('data-id');
            const statusAtual = this.getAttribute('data-status');
            const novoStatus = statusAtual === 'disponível' ? 'alugado' : 'disponível';

            // Enviar requisição para alterar o status do livro
            fetch('alterar_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    livroId: livroId,
                    novoStatus: novoStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    botao.textContent = novoStatus === 'disponível' ? 'Emprestar' : 'Devolver';
                    botao.setAttribute('data-status', novoStatus);
                    // Atualize o texto do status na página
                    const statusElement = botao.previousElementSibling;
                    statusElement.textContent = 'Status: ' + novoStatus;
                } else {
                    console.error('Erro ao alterar o status:', data.error);
                }
            })
            .catch(error => {
                console.error('Erro ao alterar o status:', error);
            });
        });
    });
});

</script>
<script>
                    const adicionarLivroBtn = document.getElementById('adicionar-livro-btn');
                    const editarLivroBtn = document.getElementById('editar-livro-btn');
                    const modal = document.getElementById('popup');
                    const modale = document.getElementById('popup-editar');
                    const closeModalBtn = document.querySelector('.close');
                    const closeModalBtne = document.querySelector('.closee');
                    const salvarLivroBtn = document.getElementById('pop');
                    const livrosContainer = document.getElementById('livros-container');

                    let contadorLivros = 0; // Contador de livros adicionados
                    let livroEditando = null; // Variável para armazenar o livro que está sendo editado

                    adicionarLivroBtn.addEventListener('click', () => {
                    limparFormulario(); // Limpa o formulário antes de abrir o popup
                    modal.style.display = 'block';
                    });

                    editarLivroBtn.addEventListener('click', () => {
                    limparFormulario(); // Limpa o formulário antes de abrir o popup
                    modal.style.display = 'block';
                    });


                    closeModalBtn.addEventListener('click', () => {
                    modal.style.display = 'none';
                    });

                    closeModalBtne.addEventListener('click', () => {
                    modale.style.display = 'none';
                    });

                    salvarLivroBtn.addEventListener('submit', (event) => {
                    event.preventDefault(); // Evita que o formulário seja enviado
                    const nome = document.getElementById('livro-nome').value;
                    const autor = document.getElementById('livro-autor').value;
                    const imagemFile = document.getElementById('livro-imagem').files[0]; // Nova linha para obter o arquivo de imagem

                    });


                    function limparFormulario() {
                    // Limpa todos os campos do formulário
                    document.getElementById('livro-nome').value = '';
                    document.getElementById('livro-imagem').value = '';
                    }
                    

                    const meuBotao = document.getElementById('meuBotao');

                    // Adiciona um event listener para o evento de clique
                    meuBotao.addEventListener('click', function() {
                        // Adiciona a classe 'vermelho' ao botão
                        meuBotao.classList.add('vermelho');
                    });





                    document.addEventListener('DOMContentLoaded', function() {
    const botoesEmprestar = document.querySelectorAll('.btn4');

    botoesEmprestar.forEach(botao => {
        botao.addEventListener('click', function() {
            const livroId = this.getAttribute('data-livro-id');
            const statusAtual = this.getAttribute('data-status-atual');

            if (statusAtual === 'disponivel') {
                // Enviar requisição para alterar o status do livro para 'alugado'
                fetch('alterar_status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        livroId: livroId,
                        novoStatus: 'alugado'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Atualizar o botão e exibir a cor vermelha
                    botao.style.backgroundColor = 'red';
                    botao.textContent = 'Alugado';
                    botao.setAttribute('data-status-atual', 'alugado');
                })
                .catch(error => {
                    console.error('Erro ao alterar o status:', error);
                });
            } else {
                console.log('Livro já está alugado.');
            }
        });
    });
});

            </script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Seleciona todos os elementos com a classe 'generos'
                    const generoElements = document.querySelectorAll('.generos');
                    const searchInput = document.querySelector('input[name="search"]');

                    // Adiciona um listener de evento de clique para cada elemento
                    generoElements.forEach(function(element) {
                        element.addEventListener('click', function() {
                            // Obtém o valor do atributo 'data-genero'
                            const genero = this.getAttribute('data-genero');
                            
                            // Define o valor do campo de pesquisa
                            searchInput.value = genero;

                            // Submete o formulário de pesquisa
                            this.closest('form').submit();
                        });
                    });
                });
            </script>
            <script>
                // Adiciona um event listener para cada gênero
                document.querySelectorAll('.generos').forEach(genreElement => {
                    genreElement.addEventListener('click', () => {
                        const genero = genreElement.getAttribute('data-genero');
                        // Redireciona para a página de livros com o gênero como parâmetro
                        window.location.href = `livros.php?search=${encodeURIComponent(genero)}`;
                    });
                });

                // Se você deseja adicionar mais lógica ou eventos, adicione aqui

                document.querySelectorAll('.btn3').forEach(btn => {
                btn.addEventListener('click', function() {
                    const livroId = this.getAttribute('data-id');

                    fetch(`get_livro.php?id=${livroId}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('editar-id').value = data.id;
                            document.getElementById('editar-titulo').value = data.titulo;
                            document.getElementById('editar-autor').value = data.autor;
                            document.getElementById('editar-editora').value = data.editora;
                            document.getElementById('editar-genero').value = data.genero;
                            document.getElementById('editar-tombo').value = data.tombo;
                            document.getElementById('editar-ano').value = data.ano;
                            document.getElementById('editar-classificacao').value = data.classificacao;
                            document.getElementById('editar-n_paginas').value = data.n_paginas;
                            document.getElementById('editar-isbn').value = data.isbn;
                            document.getElementById('popup-editar').style.display = 'flex'; // Exibe a popup
                        })
                        .catch(error => console.error('Erro ao carregar dados do livro:', error));
                });
            });

            function closePopupEditar() {
                document.getElementById('popup-editar').style.display = 'none'; // Oculta a popup
            }
            function closePopup() {
                document.getElementById('popup').style.display = 'none'; // Oculta a popup
            }


                // Código existente
            </script>










    <script>
document.querySelectorAll('.btn3').forEach(btn => {
    btn.addEventListener('click', function() {
        const livroId = this.getAttribute('data-id');

        // Carregar dados do livro
        fetch(`get_livro.php?id=${livroId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editar-id').value = data.id;
                document.getElementById('editar-titulo').value = data.titulo;
                document.getElementById('editar-autor').value = data.autor;
                document.getElementById('editar-editora').value = data.editora;
                document.getElementById('editar-genero').value = data.genero;
                document.getElementById('editar-tombo').value = data.tombo;
                document.getElementById('editar-ano').value = data.ano;
                document.getElementById('editar-classificacao').value = data.classificacao;
                document.getElementById('editar-n_paginas').value = data.n_paginas;
                document.getElementById('editar-isbn').value = data.isbn;

                // Mostrar o popup
                document.getElementById('popup-editar').style.display = 'flex'; 
            })
            .catch(error => console.error('Erro ao carregar dados do livro:', error));
    });
});

// Função para fechar o popup
function closePopupEditar() {
    document.getElementById('popup-editar').style.display = 'none'; 
}
</script>


</body>
</html>
