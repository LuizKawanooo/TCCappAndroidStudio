<?php
// Conexão com o banco de dados (substitua com suas credenciais)
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

// Inicializa a variável de mensagem
$mensagem = '';
$imagePath = '';

// Verificar se foi enviado um número de computador pelo formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['numero'], $_POST['data'], $_POST['horario'])) {
        $numero = $_POST['numero'];
        $data = $_POST['data'];
        $horario = $_POST['horario'];

        // Consultar o banco de dados para verificar a disponibilidade do computador
        $sql = "SELECT * FROM computador WHERE numero = ? AND data_disponibilidade = ? AND horario_disponibilidade = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$numero, $data, $horario]);
        $computador = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($computador) {
            $mensagem = "<p style='color:#f00; font-size:20px;'>O computador não está disponível</p>";
        } else {
            $mensagem = "<p style='color:#2ACA22; font-size:20px;'>O computador está disponível</p>";
        }
    }

    // Lidar com o upload da imagem
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $uploads_dir = 'uploads/'; // Diretório onde as imagens serão salvas
        $tmp_name = $_FILES['file']['tmp_name'];
        $name = basename($_FILES['file']['name']);
        $imagePath = $uploads_dir . $name;

        // Verifica se o diretório existe, se não, cria
        if (!is_dir($uploads_dir)) {
            mkdir($uploads_dir, 0755, true);
        }

        if (move_uploaded_file($tmp_name, $imagePath)) {
            $mensagem .= "<p style='color:#2ACA22;'>Imagem upload com sucesso: <img src='$imagePath' style='max-width: 300px;'></p>";
        } else {
            $mensagem .= "<p style='color:#f00;'>Erro ao fazer upload da imagem</p>";
        }
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
        body {
            background-image: linear-gradient(to right, #30cfd0 0%, #330867 100%);
            overflow: hidden;
            font-family: 'Open Sans', sans-serif;
        }
        .popup {
            display: none; 
            position: fixed; 
            top: 20%; 
            left: 50%; 
            transform: translate(-50%, -50%);
            width: 80%; 
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        .close {
            cursor: pointer;
            float: right;
            font-size: 24px;
        }
    </style>
</head>
<body>

<nav>
    <ul>
        <li><a href="inicio.php">Início</a></li>
        <li><a href="livros.php">Livros</a></li>
        <li><a href="ranking.php">Ranking</a></li>
        <li><a href="computadores.php">Computadores</a></li>
        <li><a href="tcc.php">TCC</a></li>
        <li><a href="contato.html">Contato</a></li>
        <li><a href="login.php">Sair</a></li>
    </ul>
</nav>

<button onclick="document.getElementById('popup').style.display='block'">Horários</button>

<div id="popup" class="popup" style="<?php echo ($_SERVER["REQUEST_METHOD"] == "POST" ? 'display: block;' : 'display: none;'); ?>">
    <span class="close" onclick="document.getElementById('popup').style.display='none'">&times;</span>

    <?php if (!empty($mensagem)): ?>
        <p><?php echo $mensagem; ?></p>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <label for="file">Upload da Planta:</label>
        <input type="file" name="file" id="file" required><br><br>

        <label for="numero">Número do Computador:</label><br>
        <select id="numero" name="numero" required>
            <option value="0"></option>
            <option value="1">Computador 1</option>
            <option value="2">Computador 2</option>
            <option value="3">Computador 3</option>
            <option value="4">Computador 4</option>
            <option value="5">Computador 5</option>
            <option value="6">Computador 6</option>
            <option value="7">Computador 7</option>
            <option value="8">Computador 8</option>
        </select><br><br>

        <label for="data">Data:</label><br>
        <input type="date" id="data" name="data" required><br><br>

        <label for="horario">Horário:</label><br>
        <select id="horario" name="horario" required>
            <option value="0"></option>
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
        </select><br><br>

        <button type="submit">Verificar Disponibilidade</button>
    </form>
</div>

</body>
</html>
