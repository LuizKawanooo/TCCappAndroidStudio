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


      

    // Buscar imagens do banco de dados
$sql = "SELECT imagem FROM plantas";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$imagens = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($imagens as $imagem) {
    // echo '<img src="' . htmlspecialchars($imagem['imagem']) . '" style="max-width:1500px; max-height:600px; position: absolute; left: 50%; transform: translateX(-50%); bottom: 150px; z-index: 10000;">';

echo '<div style="background-color: #d3d3d3; width: 1600px; height: 700px; border-radius: 15px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 10000; display: flex; justify-content: center; align-items: center;">
        <img src="' . htmlspecialchars($imagem['imagem']) . '" style="max-width: 1500px; max-height: 600px; object-fit: contain;">
      </div>';




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
                        z-index: 1000000;
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
                    select.numero {
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
                    select.horarios{
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
                    select.numero option {
                        padding: 10px; /* espaçamento interno */
                        font-size: 14px; /* tamanho da fonte */
                        color: #333; /* cor do texto */
                        background-color: #fff; /* cor de fundo */
                        cursor: pointer; /* cursor ao passar */
                    }
                    select.horarios option {
                        padding: 10px; /* espaçamento interno */
                        font-size: 14px; /* tamanho da fonte */
                        color: #333; /* cor do texto */
                        background-color: #fff; /* cor de fundo */
                        cursor: pointer; /* cursor ao passar */
                    }
                    

                    /* Estilo para quando o select estiver focado */
                    select.numero:focus {
                        outline: none; /* remove o contorno ao focar */
                        border-color: #66afe9; /* borda azul ao focar */
                        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2); /* sombra ao focar */
                    }
                    select.horarios:focus {
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
                    .data:focus{
                        outline: none;
                        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
                        border-color: #66afe9; /* borda azul ao focar */
                    }

                    .data{
                        width: 170px;
                        height: 40px;
                    }

                    
                        img {
                            position: absolute; /* Posiciona a imagem em relação ao corpo */
                            left: 50%; /* Centraliza horizontalmente */
                            transform: translateX(-50%); /* Ajusta para o centro */
                            bottom: 50px; /* Distância do fundo, ajuste conforme necessário */
                            max-width: 200px; /* Largura máxima */
                            max-height: 200px; /* Altura máxima */
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
        <svg viewBox="0 0 869 344" xmlns="http://www.w3.org/2000/svg">
            <path d="M 272 0.0130308C 164.8 1.21303 46 85.1797 0 127.013L 0 342.013L 867 342.013L 867 6.51303C 779 0.013031 684.5 127.013 616.5 127.013C 548.5 127.013 406 -1.48697 272 0.0130308Z"/>
        </svg>
    </div>








<style>
.upload-button {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            background-color: #4CAF50; /* Cor do fundo do botão */
            color: white; /* Cor do texto */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            text-decoration: none; /* Remove sublinhado */
        }

        .upload-button:hover {
            background-color: #45a049; /* Cor do botão ao passar o mouse */
        }
    input[type="file"] {
        display: none;
        border: none;
        background: #c2c2c2;
        height: 35px;
        box-shadow: 2px 11px 31px -10px rgba(0, 0, 0, 0.6);
    }

</style>


    

<!--     <br>
<form style="margin-left: 570px;" action="upload.php" method="post" enctype="multipart/form-data">

    <br>
    
    <input id="file-upload" onchange="displayFileName()" class="fileinput" type="file" name="imagem" id="imagem" required>
   
    
    <br>
    <input class="upload-button" type="submit" name="upload" value="Enviar">
</form> -->




<style>
.custom-file-label {
  background-color: #ffffff;
  color: black;
  padding: 10px 20px;
  border-radius: 4px;
  cursor: pointer;
  display: inline-block;
  margin-right: 10px;
  margin-top: -7px;
}

#file-name {
  font-size: 19px;
  color: #666;
}

.upload-button {
  background-color: #28a745;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.upload-button:hover {
  background-color: #218838;
}

</style>

<script>
function displayFileName() {
  const input = document.getElementById('file-upload');
  const fileNameSpan = document.getElementById('file-name');

  if (input.files.length > 0) {
    fileNameSpan.textContent = input.files[0].name;
  } else {
    fileNameSpan.textContent = "Adicione aqui sua planta";
  }
}
</script>

<br>
<!-- Adicionando margem ao formulário para distância do fundo cinza -->
<form style="display: flex; justify-content: space-between; align-items: center; margin-top: -7px;" action="upload.php" method="post" enctype="multipart/form-data">
    
    <!-- Label e input file -->
    <div style="display: flex; align-items: center;">
        <label for="file-upload" class="custom-file-label">Selecionar Arquivo</label>
        <input id="file-upload" onchange="displayFileName()" class="fileinput" type="file" name="imagem" required style="display: none;">
        <!-- Texto do nome do arquivo -->
        <span id="file-name" style="margin-left: 10px; color: white;">Adicione aqui sua planta</span>
    </div>

    <!-- Botão de enviar -->
    <input class="upload-button" type="submit" name="upload" value="Enviar" style="margin-left: 20px;">
</form>

















    
    
    
    <button onclick="openPopup()" id="btn1">Horários</button>



<?php
include "conexao.php";

// Data atual
$dataAtual = date('Y-m-d');

// Mensagem de status
$mensagem = '';
$horariosIndisponiveis = [];

// Verificar reservas ao enviar o formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero = $_POST['numero'];
    $data = $_POST['data'];
    $horario = $_POST['horario'];

    // Montar a consulta SQL
    $query = "SELECT * FROM reservas_computadores 
              WHERE computador_id = ? 
              AND horario = ?";

    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("is", $numero, $horario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            // Obter detalhes da reserva
            while ($reserva = $resultado->fetch_assoc()) {
                $horariosIndisponiveis[] = $reserva['horario'];
            }
            $mensagem = "Computador reservado por " . $reserva['aluno_nome'] . ".";
        } else {
            $mensagem = "Computador disponível!";
        }

        $stmt->close();
    } else {
        $mensagem = "Erro na preparação da consulta: " . $conn->error;
    }
}

$conn->close();
?>

<div id="popup" class="popup" style="<?php echo ($_SERVER["REQUEST_METHOD"] == "POST" ? 'display: block;' : 'display: none;'); ?>">
    <div class="table">
        <span class="close" onclick="closePopup()">&times;</span>
        <br>

        <p>Tetse</p>

        <?php if (!empty($mensagem)): ?>
            <p style="<?php echo strpos($mensagem, 'reservado') !== false ? 'color: red;' : ''; ?>">
                <?php echo $mensagem; ?>
            </p>
        <?php endif; ?>

        <?php if (!empty($horariosIndisponiveis)): ?>
            <p><strong>Horários Reservados:</strong></p>
            <ul>
                <?php foreach ($horariosIndisponiveis as $horarioReservado): ?>
                    <li><?php echo $horarioReservado; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form id="bookingForm" action="" method="POST" onsubmit="return validateForm()">
            <label for="numero">Número do Computador:</label><br>
            <select class="numero" id="numero" name="numero" required>
                <option value="0"></option>
                <option value="1">Computador 1</option>
                <option value="2">Computador 2</option>
                <option value="3">Computador 3</option>
                <option value="4">Computador 4</option>
                <option value="5">Computador 5</option>
                <option value="6">Computador 6</option>
            </select><br><br>

            <label for="data">Data:</label><br>
            <input type="date" id="data" name="data" value="<?php echo $dataAtual; ?>" readonly required><br><br>

            <label for="horario">Horário:</label><br>
            <select class="horarios" id="horario" name="horario" required>
                <option value="0"></option>
                <option value="07:30:00">07:30 às 08:00</option>
                <option value="08:00:00">08:00 às 08:30</option>
                <option value="08:30:00">08:30 às 09:00</option>
                <option value="09:00:00">09:00 às 09:30</option>
                <option value="09:30:00">09:30 às 10:00</option>
                <option value="10:00:00">10:00 às 10:30</option>
                <option value="10:30:00">10:30 às 11:00</option>
                <option value="11:00:00">11:00 às 11:30</option>
                <option value="11:30:00">11:30 às 12:00</option>
                <option value="12:00:00">12:00 às 12:30</option>
                <option value="12:30:00">12:30 às 13:00</option>
                <option value="13:00:00">13:00 às 13:30</option>
                <option value="13:30:00">13:30 às 14:00</option>
                <option value="14:00:00">14:00 às 14:30</option>
                <option value="14:30:00">14:30 às 15:00</option>
                <option value="15:00:00">15:00 às 15:30</option>
                <option value="15:30:00">15:30 às 16:00</option>
                <option value="16:00:00">16:00 às 16:30</option>
                <option value="16:30:00">16:30 às 17:00</option>
                <option value="17:00:00">17:00 às 17:30</option>
                <option value="17:30:00">17:30 às 18:00</option>
                <option value="18:00:00">18:00 às 18:30</option>
            </select><br><br>
    
            <button type="submit" class="btn2">Verificar Disponibilidade</button>
        </form>
    </div>
</div>

<!-- <script>
function validateForm() {
    const selectedDate = document.getElementById('data').value;
    const selectedTime = document.getElementById('horario').value;

    if (!selectedDate || !selectedTime) {
        return true; // Se a data ou horário não estiverem selecionados, não faz a verificação
    }

    return true; // Permite o envio do formulário
}
</script> -->



    

<!-- <script>
function validateForm() {
    const selectedDate = document.getElementById('data').value;
    const selectedTime = document.getElementById('horario').value;

    if (!selectedDate || !selectedTime) {
        return true; // Se a data ou horário não estiverem selecionados, não faz a verificação
    }

    const [startTime] = selectedTime.split(' às ');
    const [startHour, startMinute] = startTime.split(':');
    const selectedDateTime = new Date(selectedDate);
    selectedDateTime.setHours(startHour, startMinute, 0, 0); // Reseta segundos e milissegundos

    const currentDateTime = new Date();

    // Comparar os horários
    if (selectedDateTime < currentDateTime) {
        alert('O horário selecionado já passou. Por favor, selecione um horário válido.');
        return false; // Impede o envio do formulário
    }

    return true; // Permite o envio do formulário
}
</script>
 -->





    

</body>
</html>
