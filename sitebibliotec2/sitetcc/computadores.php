<?php
    // Conexão com o banco de dados (substitua com suas credenciais)
    $host = 'tccappionic-bd.mysql.uhserver.com';
    $db   = 'tccappionic_bd';
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

    // Verificar se foi enviado um número de computador pelo formulário
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['numero'], $_POST['data'], $_POST['horario'])) {
        $numero = $_POST['numero'];
        $data = $_POST['data'];
        $horario = $_POST['horario'];

        // Consultar o banco de dados para verificar a disponibilidade do computador
        $sql = "SELECT * FROM computador WHERE numero = ? AND data_disponibilidade = ? AND horario_disponibilidade = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$numero, $data, $horario]);
        $computador = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($computador) {
            $mensagem = "<p style='color:#f00; font-size:20px; position: absolute; top: 68%; left: 50%; transform:translate(-50%, -50%);'>O computador não está disponível</p>";
        } else {
            $mensagem = "<p style='color:#2ACA22; font-size:20px; position: absolute; top: 68%; left: 50%; transform:translate(-50%, -50%);'>O computador está disponível</p>";
        }
    }

    // Upload de imagem
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $imagem = file_get_contents($_FILES['imagem']['tmp_name']);
        $sql = "UPDATE computador SET imagem = ? WHERE numero = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$imagem, $_POST['numero']]);
    }

    // Para exibir a imagem
    if (isset($_POST['numero'])) {
        $sql = "SELECT imagem FROM computador WHERE numero = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['numero']]);
        $imagemComputador = $stmt->fetchColumn();
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliotec - computadores</title>
    <link rel="shortcut icon" href="img/logo.png">
    <?php include 'conexao.php'; ?>
</head>
<body>
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
        #img {
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
        .footer {
            width: 101vw;
            height: 50vh;
            position: absolute;
            bottom: -10%;
            left: 0;
            fill: #ffffff;
        }
        .container {
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            width: 80vw;
            height: 80vh;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            align-items: center;
        }
        .computadores {
            background-color: #fff;
            height: 300px;
            width: 300px;
            justify-content: center;
            font-size: 10px;
            text-align: left;
            align-items: center;
            display: flex;
            padding-bottom: 80px;
            color: #252527;
            box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
            flex-basis: calc(25% - 20px);
        }
        #btn1 {
            font-family: Roboto, sans-serif;
            font-size: 20px;
            color: #fff;
            background-color: #005aeb;
            padding: 15px 30px;
            border: none;
            box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
            border-radius: 50px;
            cursor: pointer;
            position: absolute;
            top: 92%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .popup {
            padding-top: 600px;
            display: none;
            position: fixed;
            top: 20%;
            left: 50%;
            transform: translate(-50%,-50%);
            width: 100%;
            height: 200%;
            background-color: rgba(0,0,0,0.5);
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .table {
            justify-content: center;
            border-radius: 10px;
            background-color: #D9D9D9;
            margin: 20% auto;
            padding: 20px;
            width: 22%;
            height: 400px;
        }
        #input {
            height: 30px;
            width: 300px;
            flex: 1;
            padding-left: 5px;
            border: 1px solid #ccc;
            border-radius: 5px 0 0 5px;
        }
        #data {
            border: none;
            border-radius: 2px;
        }
        .btn2 {
            font-family: Roboto, sans-serif;
            color: #fff;
            background-color: #005aeb;
            padding: 10px 30px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
        }
        #input:focus {
            outline: none;
        }
        input[type="date"] {
            border: none;
            width: 130px;
            height: 30px;
            border-radius: 3px;
        }
        input[type="date"]:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }
    </style>

    <script>
        function openPopup() {
            document.getElementById("popup").style.display = "block";
        }

        function closePopup() {
            document.getElementById("popup").style.display = "none";
        }
    </script>

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

    <div class="footer">
        <svg viewBox="0 0 869 344" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path fill="#007bff" d="M0 0h869l0 344H0z"></path>
        </svg>
    </div>

    <div class="container">
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="numero">Número do Computador:</label>
            <select id="data" name="numero" required>
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

            <label for="data">Data:</label>
            <input type="date" id="data" name="data" required><br><br>

            <label for="horario">Horário:</label>
            <select id="data" name="horario" required>
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

            <label for="imagem">Imagem:</label>
            <input type="file" name="imagem" id="imagem" accept="image/*" required><br><br>

            <button type="submit" class="btn2">Enviar</button>
        </form>

        <?php if (isset($imagemComputador)): ?>
            <h3>Imagem do Computador:</h3>
            <img src="data:image/jpeg;base64,<?= base64_encode($imagemComputador) ?>" alt="Imagem do Computador" style="max-width: 100%; height: auto;">
        <?php endif; ?>
    </div>

    <button onclick="openPopup()" id="btn1">Horários</button>
    
    <div id="popup" class="popup" style="<?php echo ($_SERVER["REQUEST_METHOD"] == "POST" ? 'display: block;' : 'display: none;'); ?>">
        <div class="table">
            <span class="close" onclick="closePopup()">&times;</span>
            <br>
            <?php if (!empty($mensagem)): ?>
                <p><?php echo $mensagem; ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
