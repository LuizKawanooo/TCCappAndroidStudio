// <?php
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

// $id = isset($_GET['id']) ? intval($_GET['id']) : null;

// if ($id === null) {
//     die("ID não fornecido.");
// }

// // Prepara e executa a consulta
// $sql = "SELECT * FROM livros WHERE id = ?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("i", $id);
// $stmt->execute();
// $result = $stmt->get_result();

// if ($result->num_rows > 0) {
//     $livro = $result->fetch_assoc();
// } else {
//     die("Livro não encontrado.");
// }

// $stmt->close();
// $conn->close();
// ?>

// <!DOCTYPE html>
// <html lang="pt-BR">
// <head>
//     <meta charset="UTF-8">
//     <title>Editar Livro</title>
//     <style>
//  @import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap');
//         * {
//             font-family: 'Open Sans', sans-serif;
//         }
//         #popup-editar {
//             display: grid;
//             justify-content: center;
//             border-radius: 10px;
//             position: absolute;
//             top: 50%;
//             left: 50%;
//             transform: translate(-50%, -50%);
//             z-index: 500;
//             align-itens:center;
//             background-color: #D9D9D9;
//             padding: 20px;  
//             width: 16%; /* Largura do pop-up */
//             padding-top: 6px;
//             min-width: 312px;
//         }
//         body{
//             background-color:blue;
//         }
        
//         .btn2{
//                 font-family: Roboto, sans-serif;
//                 color: #fff;
//                 background-color: #005aeb;
//                 padding: 10px 30px;
//                 border: none;
//                 -webkit-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
//                 -moz-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
//                 box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
//                 border-radius: 50px;
//                 display: flex;
//                 flex-direction: row;
//                 align-items: center;
//                 cursor: pointer;
//                 margin-top: 30px;
//                 top: 79%;
//         }
//         #overlay {
//             display: none;
//             position: fixed;
//             top: 0;
//             left: 0;
//             width: 100%;
//             height: 100%;
//             z-index: 500;
//         } 

//         .inp{
//                 height: 30px;
//                 width: 300px;
//                 flex: 1;
//                 padding-left: 5px;
//                 margin-bottom: -4px;
//                 border: 1px solid #ccc;
//                 border-radius: 7px;
//             }
//             .inpd{
//                 height: 30px;
//                 width: 150px;
//                 flex: 1;
//                 padding-left: 5px;
//                 border: 1px solid #ccc;
//                 border-radius: 5px;
//                 border-radius: 7px;
//             }
//     </style>
// </head>
// <body>
//     <div id="overlay"></div>

//     <div id="popup-editar">
//         <center><h2>Editar Livro</h2></center>
//         <form action="atualizar_livro.php" method="POST">
//             <input type="hidden" id="editar-id" name="id" value="<?php echo htmlspecialchars($livro['id']); ?>">
//             <p>
//                 <label for="editar-titulo">Título:</label>
//                 <input type="text" class="inp" id="editar-titulo" name="titulo" value="<?php echo htmlspecialchars($livro['titulo']); ?>" required>
//             </p>
//             <p>
//                 <label for="editar-autor">Autor:</label>
//                 <input type="text" class="inp" id="editar-autor" name="autor" value="<?php echo htmlspecialchars($livro['autor']); ?>" required>
//             </p>
//             <p>
//                 <label for="editar-editora">Editora:</label>
//                 <input type="text" class="inp" id="editar-editora" name="editora" value="<?php echo htmlspecialchars($livro['editora']); ?>" required>
//             </p>
//             <p>
//                 <label for="editar-genero">Gênero:</label>
//                 <input type="text" class="inp" id="editar-genero" name="genero" value="<?php echo htmlspecialchars($livro['genero']); ?>" required>
//             </p>
//             <p>
//                 <label for="editar-tombo">Tombo:</label>
//                 <input type="text" class="inp" id="editar-tombo" name="tombo" value="<?php echo htmlspecialchars($livro['tombo']); ?>" required>
//             </p>
//             <p>
//                 <label for="editar-ano">Ano:</label><br>
//                 <input type="date" class="inpd" id="editar-ano" name="ano" value="<?php echo htmlspecialchars($livro['ano']); ?>" required>
//             </p>
//             <p>
//                 <label for="editar-classificacao">Classificação:</label>
//                 <input type="text" class="inp" id="editar-classificacao" name="classificacao" value="<?php echo htmlspecialchars($livro['classificacao']); ?>" required>
//             </p>
//             <p>
//                 <label for="editar-n_paginas">Número de Páginas:</label>
//                 <input type="number" class="inp" id="editar-n_paginas" name="n_paginas" value="<?php echo htmlspecialchars($livro['n_paginas']); ?>" required>
//             </p>
//             <p>
//                 <label for="editar-isbn">ISBN:</label>
//                 <input type="text" class="inp" id="editar-isbn" name="isbn" value="<?php echo htmlspecialchars($livro['isbn']); ?>" required>
//             </p>
//             <p>
//             <label>Imagem Atual:</label><br>
//                 <?php if (!empty($livro['imagem'])): ?>
//                     <img src="<?php echo htmlspecialchars($livro['imagem']); ?>" alt="Imagem do Livro" style="max-width: 100px; max-height: 100px;"><br>
//                 <?php else: ?>
//                     <span>Nenhuma imagem disponível.</span><br>
//                 <?php endif; ?>
//             </p>
//             <p>
//                 <label for="imagem">Nova Imagem:</label>
//                 <input type="file" name="imagem" id="imagem">
//                 <small>Deixe em branco se não deseja alterar a imagem.</small>
//             </p>
//             <center><button type="submit" class="btn2">Salvar</button></center>
//             <button type="button" onclick="closePopup()">Fechar</button>
//         </form>
//     </div>

//     <script>
//         // Chama a função para abrir o popup assim que a página carregar
//         openPopup();

//         function openPopup() {
//             document.getElementById('overlay').style.display = 'block';
//             document.getElementById('popup-editar').style.display = 'block';
//         }

//         function closePopup() {
//             document.getElementById('overlay').style.display = 'none';
//             document.getElementById('popup-editar').style.display = 'none';
//             window.location.href = "https://endologic.com.br/tcc/sitebibliotec2/sitetcc/livros.php";
//         }

//     </script>
// </body>
// </html>







































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
        /* Estilos omitidos para brevidade */
    </style>
</head>
<body>
    <div id="overlay"></div>

    <div id="popup-editar">
        <center><h2>Editar Livro</h2></center>
        <form action="atualizar_livro.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="editar-id" name="id" value="<?php echo htmlspecialchars($livro['id']); ?>">
            <p>
                <label for="editar-titulo">Título:</label>
                <input type="text" class="inp" id="editar-titulo" name="titulo" value="<?php echo htmlspecialchars($livro['titulo']); ?>" required>
            </p>
            <p>
                <label for="editar-autor">Autor:</label>
                <input type="text" class="inp" id="editar-autor" name="autor" value="<?php echo htmlspecialchars($livro['autor']); ?>" required>
            </p>
            <p>
                <label for="editar-editora">Editora:</label>
                <input type="text" class="inp" id="editar-editora" name="editora" value="<?php echo htmlspecialchars($livro['editora']); ?>" required>
            </p>
            <p>
                <label for="editar-genero">Gênero:</label>
                <input type="text" class="inp" id="editar-genero" name="genero" value="<?php echo htmlspecialchars($livro['genero']); ?>" required>
            </p>
            <p>
                <label for="editar-tombo">Tombo:</label>
                <input type="text" class="inp" id="editar-tombo" name="tombo" value="<?php echo htmlspecialchars($livro['tombo']); ?>" required>
            </p>
            <p>
                <label for="editar-ano">Ano:</label>
                <input type="date" class="inpd" id="editar-ano" name="ano" value="<?php echo htmlspecialchars($livro['ano']); ?>" required>
            </p>
            <p>
                <label for="editar-classificacao">Classificação:</label>
                <input type="text" class="inp" id="editar-classificacao" name="classificacao" value="<?php echo htmlspecialchars($livro['classificacao']); ?>" required>
            </p>
            <p>
                <label for="editar-n_paginas">Número de Páginas:</label>
                <input type="number" class="inp" id="editar-n_paginas" name="n_paginas" value="<?php echo htmlspecialchars($livro['n_paginas']); ?>" required>
            </p>
            <p>
                <label for="editar-isbn">ISBN:</label>
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
            <button type="button" onclick="closePopup()">Fechar</button>
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
