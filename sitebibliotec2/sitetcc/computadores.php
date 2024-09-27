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
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliotec - computadores</title>
    <link rel="shortcut icon" href="img/logo.png">
    <?php include 'conexao.php';?>
</head>
<body>

<style>
    /* Seu estilo existente aqui */
    /* ... */
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
    <svg viewBox="0 0 869 344" xmlns="http://www.w3.org/2000/svg">
        <path d="M 272 0.0130308C 164.8 1.21303 46 85.1797 0 127.013L 0 342.013L 867 342.013L 867 6.51303C 779 0.013031 684.5 127.013 616.5 127.013C 548.5 127.013 406 -1.48697 272 0.0130308Z"/>
    </svg>
</div>

<form action="" method="POST">
    <label class="custum-file-upload" for="file">
        <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24"><g stroke-width="0" id="SVGRepo_bgCarrier"></g><g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g><g id="SVGRepo_iconCarrier"> <path fill="" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" clip-rule="evenodd" fill-rule="evenodd"></path> </g></svg>
        </div>
        <div class="text">
           <span>Click to upload image</span>
        </div>
        <input type="file" id="file">
    </label>
</form>

<button onclick="openPopup()" id="btn1">Horários</button>

<div id="popup" class="popup" style="<?php echo ($_SERVER["REQUEST_METHOD"] == "POST" ? 'display: block;' : 'display: none;'); ?>">
    <div class="table">
        <span class="close" onclick="closePopup()">&times;</span>
        <br>

        <?php if (!empty($mensagem)): ?>
            <p><?php echo $mensagem; ?></p>
        <?php endif; ?>

        <form action="" method="POST">
            <label for="numero">Número do Computador:</label><br>
            <select id="pcs" name="numero" required>
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
            <select id="horarios" name="horario" required>
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
                <option value="17:00 às 18:00">17:00 às 18:00</option>
                <option value="18:00 às 19:00">18:00 às 19:00</option>
            </select><br><br>

            <input type="submit" value="Verificar Disponibilidade">
        </form>
    </div>
</div>

</body>
</html>
