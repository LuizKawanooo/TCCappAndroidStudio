<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliotec - TCC</title>
    <link rel="shortcut icon" href="img/logo.png">
    
</head>
<body>

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap');
 
            body{
            background-image: linear-gradient(to right, #30cfd0 0%, #330867 100%);
            overflow: hidden;

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
            
            .container{
                padding: 20px;
                display: flex;
                width: 70vw;
                height: 50vh;
                position: absolute;
                top: 55%;
                left: 50%;
                transform: translate(-50%,-50%);
                align-items: center;
            }
            
            .artigo {
                background-color: #fff;
                height: 400px;
                width: 300px;
                justify-content: center;
                font-size: 11px;
                text-align: left;
                align-items: center;
                display: grid;
                padding-top: 70px;
                color: #252527;
                -webkit-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                -moz-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
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
            
            
            #status{
                
                color: green;
                text-align: center;
            }
            
            .capa{
                width: 100px;
                position: absolute;
                display: flex;
                top: 15%;
            }
            .adicionar-artigo-btn{
                font-family: Roboto, sans-serif;
                font-size: 14px;
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
                position: fixed;
                top: 89%;
                left: 50%;
                transform: translate(-50%,-50%);
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
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px 0 0 5px;
            }
            
            .barra-de-pesquisa button {
                padding: 10px 20px;
                background-color: #005aeb;
                color: white;
                border: none;
                border-radius: 0 5px 5px 0;
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
                width: 100%; /* Preencher toda a largura */
                height: 200%; /* Preencher toda a altura */
                background-color: rgba(0,0,0,0.5); /* Fundo escuro semi-transparente */
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
                left: 59%;
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
                left: 59%;
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
                background-color: #D9D9D9;
                margin: 20% auto; /* Centralizar verticalmente e deixar uma margem de 25% em cima e em baixo */
                padding: 20px;
                width: 22%; /* Largura do pop-up */
            }
            .tablee{
                display: grid;
                justify-content: center;
                border-radius: 10px;
                background-color: #D9D9D9;
                margin: 20% auto; /* Centralizar verticalmente e deixar uma margem de 25% em cima e em baixo */
                padding: 20px;
                width: 22%; /* Largura do pop-up */
                height: 30%;
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
                margin-top: 70px;
                top: 79%;
            }
            .btn3{
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
                font-size: 13px;
                top: 67,1%;
                margin-top: 70px;
                left: 54%;
            }
            #input:focus{
                outline: none;
            }
            .artigos-container {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); /* Cria colunas responsivas */
            }
            
            .quebrar-linha {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* Quebra a linha e ajusta o número de colunas conforme necessário */
            }
            .title{
                display: flex;
                justify-content: center;
                align-items: center;
                position: absolute;
                width: 1400px;
                background-color: #fff;
                height: 50px;
                top: 20%;
                left: 50%;
                transform: translate(-50%,-50%);
                color: #000;
                -webkit-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                -moz-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                border-radius: 3px;
            }

            .btn-download {
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
                font-size: 13px;
                top: 67,1%;
                margin-top: 70px;
                left: 54%;
                text-decoration: none;
            }

            .btn-download:hover {
                background-color: #0037a4;
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


<div class="container" id="artigos-container">
    <!-- Livros serão adicionados aqui -->
</div>

<div class="title">
        <h1>TRABALHOS DE CONCLUSÃO DE CURSO</h1>
</div>

<div class="adicionar-artigo-btn" id="adicionar-artigo-btn">
    Adicionar
</div>


<?php
// Conexão com o banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifique a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Seu código para inserir um novo artigo no banco de dados
}

// Consulta SQL para recuperar os artigos cadastrados
$sql = "SELECT * FROM artigo";
$result = $conn->query($sql);

// Verifica se a consulta retornou algum resultado
if ($result) {
    // Verifica se há pelo menos um artigo cadastrado
    if ($result->num_rows > 0) {
        // Saída de dados de cada linha
        echo "<div class='container'>";
        while($row = $result->fetch_assoc()) {
            // Crie uma div com as informações do artigo
            echo "<div class='artigo'>";
            echo "<center><h1>Título: <br>" . $row["titulo"]. "</h1></center>";
            // Adiciona o botão de edição
            echo "<div class='botoes'>";
            echo "<button class='btn3' data-id='" . $row["id"] . "'>Editar</button>";
            echo "<a href='" . $row["arquivo"] . "' download class='btn-download'>Download</a>";
            echo "</div>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "";
    }
} else {
    echo "Erro na consulta: " . $conn->error;
}

// Fecha a conexão com o banco de dados
$conn->close();
?>

<div id="popup" class="popup">
    <div class="table">
        <h1>Adicionar Artigo</h1>
        <form action="tcc.php" method="post" enctype="multipart/form-data"> <!-- Adicionado enctype para envio de arquivos -->
            <label for="titulo">Título:</label><br>
            <input type="text" id="artigo-nome" name="titulo" class="inp"><br>
            <label for="autor">Autor:</label><br>
            <input type="text" id="artigo-autor" name="autor" class="inp"><br>
            <label for="ano">Ano:</label><br>
            <input type="date" id="artigo-ano" name="ano" class="inp"><br>
            <br>
            <input type="file" id="artigo-capa" name="capa" accept="image/*"> <!-- Adiciona input para selecionar a capa -->
            <br>
            <input type="submit" value="Enviar" class="btn2">
        </form>
        <span class="close" onclick="closePopup()">&times;</span>
    </div>
</div>



<div id="popup-editar" class="popup">
    <div class="tablee">
        <h1>Editar Artigo</h1>
        <form id="editar-form" action="editar_artigo.php" method="post">
            <!-- Campos do formulário -->
            <input type="hidden" id="editar-id" name="id">
            <label for="editar-titulo">Título:</label><br>
            <input type="text" id="editar-titulo" name="titulo" class="inp"><br>
            <label for="editar-autor">Autor:</label><br>
            <input type="text" id="editar-autor" name="autor" class="inp"><br>
            <label for="editar-ano">Ano:</label><br>
            <input type="date" id="editar-ano" name="ano" class="inp"><br>
            <br>
            <label for="artigo-arquivo">Arquivo:</label><br>
            <input type="file" id="artigo-arquivo" name="arquivo" accept=".pdf,.doc,.docx"><br> <!-- Permitir upload de documentos -->
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
    $ano = $_POST['ano'];

    // Processa o upload do arquivo
    $arquivo = NULL;
    if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['arquivo']['tmp_name'];
        $name = basename($_FILES['arquivo']['name']);
        $upload_dir = 'uploads/';
        $upload_file = $upload_dir . $name;

        // Cria o diretório de uploads se não existir
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Move o arquivo para o diretório de uploads
        if (move_uploaded_file($tmp_name, $upload_file)) {
            $arquivo = $upload_file;
            
        } else {
            echo "Erro ao fazer upload do arquivo.";
            exit();
        }
    }

    // Prepara a consulta SQL para inserção
    $stmt = $conn->prepare("INSERT INTO artigo (titulo, autor, ano, arquivo) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $titulo, $autor, $ano, $arquivo);

    // Executa a consulta
    if ($stmt->execute()) {
        echo "<script>window.location.href = 'tcc.php';</script>";
    } else {
        echo "Erro ao inserir registro: " . $conn->error;
    }

    // Fecha a conexão com o banco de dados
    $stmt->close();
    $conn->close();
}
?>












<script>
                    const adicionarArtigoBtn = document.getElementById('adicionar-artigo-btn');
                    const editarArtigoBtn = document.getElementById('editar-artigo-btn');
                    const modal = document.getElementById('popup');
                    const modale = document.getElementById('popup-editar');
                    const closeModalBtn = document.querySelector('.close');
                    const closeModalBtne = document.querySelector('.closee');
                    const salvarArtigoBtn = document.getElementById('pop');
                    const ArtigosContainer = document.getElementById('artigos-container');

                    let contadorArtigod = 0; // Contador de livros adicionados
                    let artigoEditando = null; // Variável para armazenar o livro que está sendo editado

                    adicionarArtigoBtn.addEventListener('click', () => {
                    limparFormulario(); // Limpa o formulário antes de abrir o popup
                    modal.style.display = 'block';
                    });

                    editarArtigoBtn.addEventListener('click', () => {
                    limparFormulario(); // Limpa o formulário antes de abrir o popup
                    modal.style.display = 'block';
                    });


                    closeModalBtn.addEventListener('click', () => {
                    modal.style.display = 'none';
                    });

                    closeModalBtne.addEventListener('click', () => {
                    modale.style.display = 'none';
                    });

                    salvarArtigoBtn.addEventListener('submit', (event) => {
                    event.preventDefault(); // Evita que o formulário seja enviado
                    const nome = document.getElementById('artigo-nome').value;
                    const autor = document.getElementById('artigo-autor').value;
                    const capaFile = document.getElementById('livro-capa').files[0]; // Nova linha para obter o arquivo de imagem

                    });


                    function limparFormulario() {
                    // Limpa todos os campos do formulário
                    document.getElementById('artigo-nome').value = '';
                    document.getElementById('artigo-capa').value = '';
                    }
                    

            </script>

        
            <script>
                

                document.querySelectorAll('.btn3').forEach(btn => {
                btn.addEventListener('click', function() {
                    const artigoId = this.getAttribute('data-id');

                    fetch(`get_artigo.php?id=${artigoId}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('editar-id').value = data.id;
                            document.getElementById('editar-titulo').value = data.titulo;
                            document.getElementById('editar-autor').value = data.autor;
                            document.getElementById('editar-ano').value = data.ano;
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

</body>
</html>