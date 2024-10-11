<?php
// Conexão com o banco de dados (o código já está aqui)
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
        /* Estilos omitidos para brevidade */
    </style>
</head>
<body>
    <div id="overlay"></div>

    <div id="popup-editar">
        <center><h2>Editar Livro</h2></center>
        <form action="atualizar_livro.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="editar-id" name="id" value="<?php echo htmlspecialchars($livro['id']); ?>">
            <!-- Exibir imagem atual -->
            <p>
                <label>Imagem Atual:</label><br>
                <?php if (!empty($livro['imagem'])): ?>
                    <img src="<?php echo htmlspecialchars($livro['imagem']); ?>" alt="Imagem do Livro" style="max-width: 100px; max-height: 100px;"><br>
                <?php else: ?>
                    <span>Nenhuma imagem disponível.</span><br>
                <?php endif; ?>
            </p>
            <p>
                <label for="editar-imagem">Nova Imagem:</label>
                <input type="file" class="inp" id="editar-imagem" name="imagem">
                <small>Deixe em branco se não deseja alterar a imagem.</small>
            </p>
            <!-- Os demais campos do formulário permanecem iguais -->
            <p>
                <label for="editar-titulo">Título:</label>
                <input type="text" class="inp" id="editar-titulo" name="titulo" value="<?php echo htmlspecialchars($livro['titulo']); ?>" required>
            </p>
            <!-- Outros campos aqui -->
            <center><button type="submit" class="btn2">Salvar</button></center>
            <button type="button" onclick="closePopup()">Fechar</button>
        </form>
    </div>

    <script>
        // Script para abrir e fechar o popup
        function openPopup() {
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('popup-editar').style.display = 'block';
        }

        function closePopup() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('popup-editar').style.display = 'none';
            window.location.href = "https://endologic.com.br/tcc/sitebibliotec2/sitetcc/livros.php";
        }
        
        // Chama a função para abrir o popup assim que a página carregar
        openPopup();
    </script>
</body>
</html>
