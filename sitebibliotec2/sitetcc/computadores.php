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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['numero'], $_POST['data'], $_POST['horario'], $_FILES['file'])) {
        $numero = $_POST['numero'];
        $data = $_POST['data'];
        $horario = $_POST['horario'];
        
        // Processar a imagem
        $file = $_FILES['file'];

        // Verificar se houve erro no upload
        if ($file['error'] == UPLOAD_ERR_OK) {
            $imageData = file_get_contents($file['tmp_name']);
            $imageData = base64_encode($imageData); // Opcional: se você quiser armazenar como base64

            // Consultar o banco de dados para verificar a disponibilidade do computador
            $sql = "SELECT * FROM computador WHERE numero = ? AND data_disponibilidade = ? AND horario_disponibilidade = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$numero, $data, $horario]);
            $computador = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($computador) {
                $mensagem = "<p style='color:#f00;'>O computador não está disponível</p>";
            } else {
                // Inserir a imagem e as informações do computador no banco de dados
                $insertSql = "INSERT INTO computador (numero, data_disponibilidade, horario_disponibilidade, imagem) VALUES (?, ?, ?, ?)";
                $insertStmt = $pdo->prepare($insertSql);
                $insertStmt->execute([$numero, $data, $horario, $imageData]);
                
                $mensagem = "<p style='color:#2ACA22;'>O computador está disponível e a imagem foi carregada com sucesso.</p>";
            }
        } else {
            $mensagem = "<p style='color:#f00;'>Erro no upload da imagem.</p>";
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

                    .custum-file-upload {
                      height: 600px;
                      width: 1300px;
                      margin-top: 70px;  
                      display: flex;
                      flex-direction: column;
                      align-items: space-between;
                      gap: 20px;
                      cursor: pointer;
                      align-items: center;
                      justify-content: center;
                      border: 2px dashed #cacaca;
                      background-color: #DCDCDC;
                        position: absolute;
                        z-index: auto;
                        left: 50%;
                        top: 40%;
                        transform: translate(-50%,-50%);
                      padding: 1.5rem;
                      border-radius: 10px;
                      box-shadow: 0px 48px 35px -48px rgba(0,0,0,0.1);
                    }
                    
                    .custum-file-upload .icon {
                      display: flex;
                      align-items: center;
                      justify-content: center;
                    }
                    
                    .custum-file-upload .icon svg {
                      height: 80px;
                      fill: rgba(75, 85, 99, 1);
                    }
                    
                    .custum-file-upload .text {
                      display: flex;
                      align-items: center;
                      justify-content: center;
                    }
                    
                    .custum-file-upload .text span {
                      font-weight: 400;
                      color: rgba(75, 85, 99, 1);
                    }
                    
                    .custum-file-upload input {
                      display: none;
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
    
  
<form action="" method="POST" enctype="multipart/form-data">

    <label class="custum-file-upload" for="file">
        <div class="icon">
        <svg xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24"><g stroke-width="0" id="SVGRepo_bgCarrier"></g><g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g><g id="SVGRepo_iconCarrier"> <path fill="" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" clip-rule="evenodd" fill-rule="evenodd"></path> </g></svg>
        </div>
        <div class="text">
           <span>Click to upload image</span>
           </div>
           <input type="file" id="file" name="file required">
    </label>
    <button type="submit" >Submit</button>
</form>

    <?php if (!empty($mensagem)): ?>
    <p><?php echo $mensagem; ?></p>
    <?php if (isset($imageData)): ?>
        <img src="data:image/jpeg;base64,<?php echo $imageData; ?>" alt="Uploaded Image" style="max-width: 200px; max-height: 200px;">
    <?php endif; ?>
<?php endif; ?>

    
    
    
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

            <label for="data">Data:</label><br>
            <input type="date" id="data" name="data" required><br><br>

            <label for="horario">Horário:</label><br>
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
            </select><br><br><br><br>
    
            <button type="submit" class="btn2">Verificar Disponibilidade</button>
        </form>
    </div>
</div>


    

</body>
</html>
