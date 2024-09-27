<?php
// Conexão com o banco de dados
$host = 'tccappionic-bd.mysql.uhserver.com';
$db = 'tccappionic_bd';
$user = 'ionic_perfil_bd';
$pass = '{[UOLluiz2019';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    die('Erro na conexão: ' . $e->getMessage());
}

// Mensagem de feedback
$mensagem = '';

// Verifica se um arquivo foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['imagem'])) {
    $numero = $_POST['numero'];
    $data = $_POST['data'];
    $horario = $_POST['horario'];
    $usuario_email = $_POST['usuario_email'];
    $imagem = $_FILES['imagem'];

    // Lê o conteúdo do arquivo da imagem
    $imagemBlob = file_get_contents($imagem['tmp_name']);

    // Insere os dados no banco de dados
    $sql = "INSERT INTO computador (data_disponibilidade, horario_disponibilidade, usuario_email, imagem) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$data, $horario, $usuario_email, $imagemBlob])) {
        $mensagem = "Imagem e informações carregadas com sucesso.";
    } else {
        $mensagem = "Erro ao salvar as informações no banco de dados.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliotec - Computadores</title>
    <link rel="shortcut icon" href="img/logo.png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap');
        body {
            background-image: linear-gradient(to right, #30cfd0 0%, #330867 100%);
            overflow: hidden;
        }
        * {
            margin: 0 auto;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Open Sans', sans-serif;
        }
        /* Estilos adicionais */
        .popup {
            display: none; /* Oculta o pop-up por padrão */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }
        .overlay {
            display: none; /* Oculta a sobreposição por padrão */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>
    <script>
        function openPopup() {
            document.getElementById("popup").style.display = "block";
            document.getElementById("overlay").style.display = "block";
        }
        
        function closePopup() {
            document.getElementById("popup").style.display = "none";
            document.getElementById("overlay").style.display = "none";
        }
    </script>
</head>
<body>

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

<button onclick="openPopup()">Adicionar Computador</button>

<div class="overlay" id="overlay" onclick="closePopup()"></div>

<div class="popup" id="popup">
    <span onclick="closePopup()" style="cursor:pointer;">&times; Fechar</span>
    <h3>Adicionar Computador</h3>
    
    <?php if ($mensagem): ?>
        <p><?php echo $mensagem; ?></p>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <label for="numero">Número do Computador:</label>
        <select name="numero" required>
            <option value="0">Selecione um computador</option>
            <option value="1">Computador 1</option>
            <option value="2">Computador 2</option>
            <option value="3">Computador 3</option>
            <option value="4">Computador 4</option>
            <option value="5">Computador 5</option>
            <option value="6">Computador 6</option>
            <option value="7">Computador 7</option>
            <option value="8">Computador 8</option>
        </select>
        <br>
        <label for="data">Data:</label>
        <input type="date" name="data" required>
        <br>
        <label for="horario">Horário:</label>
        <select name="horario" required>
            <option value="07:00 às 08:00">07:00 às 08:00</option>
            <option value="08:00 às 09:00">08:00 às 09:00</option>
            <option value="09:00 às 10:00">09:00 às 10:00</option>
            <option value="10:00 às 11:00">10:00 às 11:00</option>
            <option value="11:00 às 12:00">11:00 às 12:00</option>
            <option value="12:00 às 13:00">12:00 às 13:00</option>
            <option value="13:00 às 14:00">13:00 às 14:00</option>
            <option value="14:00 às 15:00">14:00 às 15:00</option>
            <option value="15:00 às 16:00">15:00 às 16:00</option>
            <option value="16:00 às 17:00">16:00 às 17:00</option>
        </select>
        <br>
        <label for="usuario_email">Email do Usuário:</label>
        <input type="email" name="usuario_email" required>
        <br>
        <label for="imagem">Selecione a imagem:</label>
        <input type="file" name="imagem" accept="image/*" required>
        <br>
        <input type="submit" value="Upload">
    </form>
</div>

</body>
</html>
