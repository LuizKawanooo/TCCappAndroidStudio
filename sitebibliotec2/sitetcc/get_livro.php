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

$id = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($id === null) {
    die("ID não fornecido.");
}

// Prepara e executa a consulta
$sql = "SELECT * FROM livros WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $livro = $result->fetch_assoc();
} else {
    die("Livro não encontrado.");
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Livro</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap');
        * {
            font-family: 'Open Sans', sans-serif;
        }
            body{
            background-image: linear-gradient(to right, #30cfd0 0%, #330867 100%);
            overflow-y: scroll;
            overflow-x: hidden;

            }

        .table {
            display: grid;
            justify-content: center;
            border-radius: 10px;
            position: absolute;
            top: 50%;
            left: 50%;
            z-index: 500;
            background-color: #D9D9D9;
            padding: 20px;
            min-width: 380px;
            max-width: 400px;
            text-align: left;
            transform: translate(-50%, -50%);
            zoom: 0.9;

        }
        .inp{
                height: 30px;
                width: 97%;
                flex: 1;
                padding-left: 5px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }
        .inpd {
                height: 30px;
                flex: 1;
                padding-left: 5px;
                border: 1px solid #ccc;
                border-radius: 5px;
        }
        .btn2 {
                font-family: Roboto, sans-serif;
                color: #fff;
                background-color: #005aeb;
                padding: 10px 30px;
                border: none;
                -webkit-box-shadow: 2px 11px 31px -10px rgba(0, 0, 0, 0.6);
                -moz-box-shadow: 2px 11px 31px -10px rgba(0, 0, 0, 0.6);
                box-shadow: 2px 11px 31px -10px rgba(0, 0, 0, 0.6);
                border-radius: 50px;
                display: flex;
                flex-direction: row;
                align-items: center;
                cursor: pointer;
                margin-top: 30px;

        }

        .btn:hover{

                font-family: Roboto, sans-serif;
                color: #fff;
                background-color: #024bc2;
                padding: 10px 30px;
                border: none;
                -webkit-box-shadow: 2px 11px 31px -10px rgba(0, 0, 0, 0.6);
                -moz-box-shadow: 2px 11px 31px -10px rgba(0, 0, 0, 0.6);
                box-shadow: 2px 11px 31px -10px rgba(0, 0, 0, 0.6);
                border-radius: 50px;
                display: flex;
                flex-direction: row;
                align-items: center;
                cursor: pointer;
                margin-top: 30px;
        
        }
        
        .btnfechar {
            width: 30px;
            height: 30px;
            border-radius: 4px;
            border: none;
            background: #ff0000;
            color: #ffffff;
            font-weight: bold;
            position: absolute;
            top: 2.3%;
            left: 89%;
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

        lable{
            font-size: 20px;
            margin-bottom: -8px;
        }

    </style>

    
</head>
<body>
    <div id="overlay"></div>

    <div class="table" id="popup-editar">
        <center><h2>Editar Livro</h2></center>
        <form action="atualizar_livro.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="editar-id" name="id" value="<?php echo htmlspecialchars($livro['id']); ?>">
            <p>
                <label for="editar-titulo">Título:</label><br>
                <input type="text" class="inp" id="editar-titulo" name="titulo" value="<?php echo htmlspecialchars($livro['titulo']); ?>" required>
            </p>
            <p>
                <label for="editar-autor">Autor:</label><br>
                <input type="text" class="inp" id="editar-autor" name="autor" value="<?php echo htmlspecialchars($livro['autor']); ?>" required>
            </p>
            <p>
                <label for="editar-editora">Editora:</label><br>
                <input type="text" class="inp" id="editar-editora" name="editora" value="<?php echo htmlspecialchars($livro['editora']); ?>" required>
            </p>
            <p>
                <label for="editar-genero">Gênero:</label><br>
                <input type="text" class="inp" id="editar-genero" name="genero" value="<?php echo htmlspecialchars($livro['genero']); ?>" required>
            </p>
            <p>
                <label for="editar-tombo">Tombo:</label><br>
                <input type="text" class="inp" id="editar-tombo" name="tombo" value="<?php echo htmlspecialchars($livro['tombo']); ?>" required>
            </p>
            <p>
                <label for="editar-ano">Ano:</label><br>
                <input type="date" class="inpd" id="editar-ano" name="ano" value="<?php echo htmlspecialchars($livro['ano']); ?>" required>
            </p>
            <p>
                <label for="editar-classificacao">Classificação:</label><br>
                <input type="text" class="inp" id="editar-classificacao" name="classificacao" value="<?php echo htmlspecialchars($livro['classificacao']); ?>" required>
            </p>
            <p>
                <label for="editar-n_paginas">Número de Páginas:</label><br>
                <input type="number" class="inp" id="editar-n_paginas" name="n_paginas" value="<?php echo htmlspecialchars($livro['n_paginas']); ?>" required>
            </p>
            <p>
                <label for="editar-isbn">ISBN:</label><br>
                <input type="text" class="inp" id="editar-isbn" name="isbn" value="<?php echo htmlspecialchars($livro['isbn']); ?>" required>
            </p>
            <p>
                <label>Imagem Atual:</label><br>
                <?php if (!empty($livro['imagem'])): ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($livro['imagem']); ?>" alt="Imagem do Livro" style="max-width: 100px; max-height: 100px;"><br>
                <?php else: ?>
                    <span>Nenhuma imagem disponível.</span><br>
                <?php endif; ?>
            </p>
            <p>
                <label for="imagem">Nova Imagem:</label>
                <input type="file" name="imagem" id="imagem">
                <small>Deixe em branco se não deseja alterar a imagem.</small>
            </p>
            <center><button type="submit" class="btn2">Salvar</button></center>
            <button class="btnfechar" type="button" onclick="closePopup()">X</button>
        </form>
    </div>

    <script>
        // Chama a função para abrir o popup assim que a página carregar
        openPopup();

        function openPopup() {
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('popup-editar').style.display = 'block';
        }

        function closePopup() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('popup-editar').style.display = 'none';
            window.location.href = "https://endologic.com.br/tcc/sitebibliotec2/sitetcc/livros.php";
        }
    </script>


    <div class="footer">
        <svg viewBox="0 0 869 344" xmlns="http://www.w3.org/2000/svg">
            <path d="M 272 0.0130308C 164.8 1.21303 46 85.1797 0 127.013L 0 342.013L 867 342.013L 867 6.51303C 779 0.013031 684.5 127.013 616.5 127.013C 548.5 127.013 406 -1.48697 272 0.0130308Z"/>
        </svg>
    </div>



    
</body>
</html>

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
    $id = $_POST['id'];

    // Inicializa a variável imagem com a imagem atual
    $imagem = null;

    // Verifica se a nova imagem foi enviada
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
        // Lê a imagem e armazena em uma variável
        $imagem = file_get_contents($_FILES['imagem']['tmp_name']);
    } else {
        // Se não houver nova imagem, busca a imagem atual no banco de dados
        $sql = "SELECT imagem FROM livros WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($imagem);
        $stmt->fetch();
        $stmt->close();
    }

    // Prepara a consulta SQL para atualização
    $sqlUpdate = "UPDATE livros SET titulo=?, autor=?, genero=?, editora=?, tombo=?, ano=?, classificacao=?, n_paginas=?, isbn=?, imagem=? WHERE id=?";
    $stmtUpdate = $pdo->prepare($sqlUpdate);

    // Tenta executar a atualização
    if ($stmtUpdate->execute([$titulo, $autor, $genero, $editora, $tombo, $ano, $classificacao, $n_paginas, $isbn, $imagem, $id])) {
        header("Location: livros.php?message=Livro atualizado com sucesso!");
        exit;
    } else {
        header("Location: livros.php?message=Erro ao atualizar no banco de dados.");
        exit;
    }
}
?>
