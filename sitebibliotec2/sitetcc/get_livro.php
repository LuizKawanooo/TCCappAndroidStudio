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
        #popup-editar {
            display: grid;
            justify-content: center;
            border-radius: 10px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 500;
            background-color: #D9D9D9;
            padding: 20px;  
            width: 13%; /* Largura do pop-up */
        }
        #overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 500;
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
    </style>
</head>
<body>
    <div id="overlay" onclick="closePopup()"></div>

    <div id="popup-editar">
        <h2>Editar Livro</h2>
        <form action="atualizar_livro.php" method="POST">
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
                <input type="number" class="inpd" id="editar-ano" name="ano" value="<?php echo htmlspecialchars($livro['ano']); ?>" required>
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
            <button type="submit">Salvar</button>
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
        }
    </script>
</body>
</html>
