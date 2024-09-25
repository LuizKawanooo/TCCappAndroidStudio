<?php
// Conexão com o banco de dados
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
$imagemExibida = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['imagem'])) {
        // Processa o upload da imagem
        $imagem = file_get_contents($_FILES['imagem']['tmp_name']);
        
        // Insere a imagem no banco de dados
        $sql = "INSERT INTO computador (imagem) VALUES (?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$imagem]);

        // Recupera a imagem para exibição
        $imagemExibida = base64_encode($imagem);
    } elseif (isset($_POST['numero'], $_POST['data'], $_POST['horario'])) {
        $numero = $_POST['numero'];
        $data = $_POST['data'];
        $horario = $_POST['horario'];

        // Consultar a disponibilidade do computador
        $sql = "SELECT * FROM computador WHERE numero = ? AND data_disponibilidade = ? AND horario_disponibilidade = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$numero, $data, $horario]);
        $computador = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($computador) {
            $mensagem = "<p style='color:#f00;'>O computador não está disponível</p>";
        } else {
            $mensagem = "<p style='color:#2ACA22;'>O computador está disponível</p>";
        }
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

                    .footer {
                        width: 101vw;
                        height:50vh;
                        position: absolute;
                        bottom: -10%;
                        left: 0;
                        fill: #ffffff;
                    }

                    .container{
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
                        -webkit-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                        -moz-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                        box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                        flex-basis: calc(25% - 20px);
                    }

                    .pc{
                        padding-top: 15px;
                        max-width: 20%;
                        max-height: 20%;
                        position: absolute;
                        display: flex;
                    }

                    .computadores h1{
                        padding-bottom: 150px;
                    }

                    #btn1 {
                        font-family: Roboto, sans-serif;
                        font-weight: 0;
                        font-size: 20px;
                        color: #fff;
                        background-color: #005aeb;
                        padding: 15px 30px;
                        border: none;
                        -webkit-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                        -moz-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                        box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                        border-radius: 50px;
                        display: flex;
                        flex-direction: row;
                        align-items: center;
                        top: 92%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                        cursor: pointer;
                        position: absolute;
                    }

                    .btn1:hover{
                    padding: 10px 28px;
                    border: none;
                    }

                    .popup {
                        padding-top: 600px;
                        display: none; /* Por padrão, o pop-up estará oculto */
                        position: fixed; /* Posicionamento fixo para que o pop-up fique no mesmo lugar ao rolar a página */
                        top: 20%;
                        left: 50%;
                        transform: translate(-50%,-50%);
                        width: 100%; /* Preencher toda a largura */
                        height: 200%; /* Preencher toda a altura */
                        background-color: rgba(0,0,0,0.5);
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

                    .table{
                        
                        justify-content: center;
                        border-radius: 10px;
                        background-color: #D9D9D9;
                        margin: 20% auto; /* Centralizar verticalmente e deixar uma margem de 25% em cima e em baixo */
                        padding: 20px;
                        width: 22%; /* Largura do pop-up */
                        height: 400px;
                    }

                    .table close{
                        padding-left: 100px;

                    }
                    #input{
                        height: 30px;
                        width: 300px;
                        flex: 1; 
                        padding-left: 5px;
                        border: 1px solid #ccc;
                        border-radius: 5px 0 0 5px; 
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

                        top: 79%;
                    }
                    #input:focus{
                        outline: none;
                    }

                    /* Estilo para o select */
                    select#pcs {
                        width: 200px; /* largura desejada */
                        padding: 10px; /* espaçamento interno */
                        font-size: 16px; /* tamanho da fonte */
                        border: 1px solid #ccc; /* borda cinza */
                        border-radius: 4px; /* borda arredondada */
                        appearance: none; /* remove o estilo padrão do sistema */
                        background-color: #fff; /* cor de fundo */
                        position: relative; /* necessário para posicionar as opções */
                        cursor: pointer; /* cursor ao passar */
                    }
                    select#horarios{
                        width: 200px; /* largura desejada */
                        padding: 10px; /* espaçamento interno */
                        font-size: 16px; /* tamanho da fonte */
                        border: 1px solid #ccc; /* borda cinza */
                        border-radius: 4px; /* borda arredondada */
                        appearance: none; /* remove o estilo padrão do sistema */
                        background-color: #fff; /* cor de fundo */
                        position: relative; /* necessário para posicionar as opções */
                        cursor: pointer; /* cursor ao passar */
                    }

                    /* Estilo para as opções */
                    select#pcs option {
                        padding: 10px; /* espaçamento interno */
                        font-size: 14px; /* tamanho da fonte */
                        color: #333; /* cor do texto */
                        background-color: #fff; /* cor de fundo */
                        cursor: pointer; /* cursor ao passar */
                    }
                    select#horarios option {
                        padding: 10px; /* espaçamento interno */
                        font-size: 14px; /* tamanho da fonte */
                        color: #333; /* cor do texto */
                        background-color: #fff; /* cor de fundo */
                        cursor: pointer; /* cursor ao passar */
                    }
                    

                    /* Estilo para quando o select estiver focado */
                    select#pcs:focus {
                        outline: none; /* remove o contorno ao focar */
                        border-color: #66afe9; /* borda azul ao focar */
                        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2); /* sombra ao focar */
                    }
                    select#horarios:focus {
                        outline: none; /* remove o contorno ao focar */
                        border-color: #66afe9; /* borda azul ao focar */
                        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2); /* sombra ao focar */
                    }
                    

                    /* Estilo para as opções quando o select estiver aberto */
                    
                    input[type="date"]{
                        border: none;
                        width: 130px;
                        height: 30px;
                        border-radius: 3px;
                        padding: 4px;
                        
                    }
                    input[type="date"]:focus{
                        outline: none;
                        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
                        border-color: #66afe9; /* borda azul ao focar */
                    }
                    #data:focus{
                        outline: none;
                        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
                        border-color: #66afe9; /* borda azul ao focar */
                    }

                    #data{
                        width: 170px;
                        height: 40px;
                    }

                </style>

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
    
    <div class="container">
        <h2>Enviar Imagem do Computador</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="imagem">Selecione a imagem:</label>
            <input type="file" name="imagem" id="imagem" required><br><br>
            <button type="submit">Enviar Imagem</button>
        </form>

        <?php if ($imagemExibida): ?>
            <div class="imagem-container">
                <h3>Imagem Enviada:</h3>
                <img src="data:image/jpeg;base64,<?php echo $imagemExibida; ?>" style="max-width: 100%; height: auto;">
            </div>
        <?php endif; ?>

        <button onclick="openPopup()" id="btn1">Horários</button>
    </div>

    <div id="popup" class="popup" style="<?php echo ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_FILES['imagem']) ? 'display: block;' : 'display: none;'); ?>">
        <span class="close" onclick="closePopup()">&times;</span>
        <br>

        <?php if (!empty($mensagem)): ?>
            <p><?php echo $mensagem; ?></p>
        <?php endif; ?>

        <form action="" method="POST">
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
    
            <button type="submit" class="btn2">Verificar Disponibilidade</button>
        </form>
    </div>

    <script>
        function openPopup() {
            document.getElementById("popup").style.display = "block";
        }
        
        function closePopup() {
            document.getElementById("popup").style.display = "none";
        }
    </script>
</body>
</html>
