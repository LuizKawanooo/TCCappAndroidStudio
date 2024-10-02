<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliotec - Ranking</title>
    <link rel="shortcut icon" href="img/logo.png">
    <?php include 'conexao.php'; ?>
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
            .footer {
            width: 101vw;
            height:50vh;
            position: absolute;
            bottom: -10%;
            left: 0;
            fill: #ffffff;
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
            
            .gen{
                justify-content: center;
                align-items: center;
                text-align: center;
                position: absolute;
                background-color: rgb(0, 0, 0,0.4);
                backdrop-filter: blur(10px);
                font-weight: bold;
                width: 20vw;
                height: 100vh;
                padding-top: 10px;
                color: #fff;
                box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
            
            }
            
            .container{
                padding: 20px;
                display: flex;
                width: 70vw;
                height: 50vh;
                position: absolute;
                top: 55%;
                left: 60%;
                transform: translate(-50%,-50%);
                align-items: center;
            }
            
            .livro {
                background-color: #fff;
                height: 400px;
                width: 300px;
                justify-content: center;
                font-size: 11px;
                text-align: left;
                align-items: center;
                display: grid;
                padding-top: 70px;
                color: #252527;
                -webkit-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                -moz-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
            }
            
            
            .principal{
                width: 100vw;
                height: 100vh;  
                display: fixed;
            
            }
            
            #btn1 {
                font-family: Roboto, sans-serif;
                font-weight: 0;
                font-size: 14px;
                color: #fff;
                background-color: #30cfd0;
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
                position: absolute;
                top: 79%;
            }
            
            .btn1:hover{
            padding: 10px 28px;
            border: none;
            }
            
            .generos{
                justify-content: center;
                align-items: center;
                font-size: 20px;
                display: flex;
                text-align: center;
                height: 90px;
                margin-bottom: 10px;
                margin-top: 30px;
                
            }
            .generos:hover{
                background-color: #30cfd0;
                text-decoration: none;
                transition: background .5s;
            }
            
            #status{
                
                color: green;
                text-align: center;
            }
            
            .capa{
                width: 100px;
                position: absolute;
                display: flex;
                top: 15%;
            }
            .adicionar-livro-btn{
                font-family: Roboto, sans-serif;
                font-size: 14px;
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
                position: fixed;
                top: 89%;
                left: 57%;
            }
            
            .barra-de-pesquisa {
                display: flex;
                width: 900px;
                position: absolute;
                left: 37%;
                top: 14%;
            }
            
            .barra-de-pesquisa input[type="text"] {
                flex: 1;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px 0 0 5px;
            }
            
            .barra-de-pesquisa button {
                padding: 10px 20px;
                background-color: #005aeb;
                color: white;
                border: none;
                border-radius: 0 5px 5px 0;
                cursor: pointer;
            }
            
            .barra-de-pesquisa button:hover {
                background-color: #0010eb;
            }
            .barra-de-pesquisa input[type="text"]:focus {
                outline: none;
            }
            
            
            .popup {
                padding-top: 600px;
                display: none; /* Por padrão, o pop-up estará oculto */
                position: fixed; /* Posicionamento fixo para que o pop-up fique no mesmo lugar ao rolar a página */
                top: 10%;
                left: 50%;
                transform: translate(-50%,-50%);
                width: 100%; /* Preencher toda a largura */
                height: 200%; /* Preencher toda a altura */
                background-color: rgba(0,0,0,0.5); /* Fundo escuro semi-transparente */
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

            .closee {
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
            
            .closee:hover,
            .closee:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
            }
            
            .table{
                display: grid;
                justify-content: center;
                border-radius: 10px;
                background-color: #D9D9D9;
                margin: 20% auto; /* Centralizar verticalmente e deixar uma margem de 25% em cima e em baixo */
                padding: 20px;
                width: 22%; /* Largura do pop-up */
            }
            
            .table close{
                padding-left: 100px;
            
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
                margin-top: 70px;
                top: 79%;
            }
            .btn3{
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
                font-size: 13px;
                top: 67,1%;
                margin-top: 70px;
                left: 54%;
            }
            #input:focus{
                outline: none;
            }
            .livros-container {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); /* Cria colunas responsivas */
            }
            
            .quebrar-linha {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* Quebra a linha e ajusta o número de colunas conforme necessário */
            }
            .ranking-table {
            margin: 20px auto;
            width: 80%;
            background-color: #D9D9D9;
            border-radius: 10px;
            box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
            padding: 20px;
            }
            .ranking-table table {
                width: 100%;
                border-collapse: collapse;
            }
            .ranking-table th, .ranking-table td {
                padding: 10px;
                text-align: left;
            }
            .ranking-table th {
                background-color: #330867;
                color: #fff;
            }
            .ranking-table tr:nth-child(even) {
                background-color: #f2f2f2;
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

<!--     <div class="ranking-table">
        <center><h1>Ranking de Leitores</h1></center>
        <table><br>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Pontos</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consultar dados de leitores e calcular pontos
                $sql = "SELECT registrar_usuarios.nome_exibicao, COUNT(livros_lidos.leitor_ID) * 100 AS pontos 
                        FROM registrar_usuarios 
                        LEFT JOIN livros_lidos ON registrar_usuarios.leitor_ID = livros_lidos.leitor_ID 
                        GROUP BY leitor.leitor_ID, registrar_usuarios.nome_exibicao 
                        ORDER BY pontos DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Exibir dados na tabela
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['nome']}</td>
                                <td>{$row['pontos']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>Nenhum dado encontrado</td></tr>";
                }

                // Fechar conexão
                $conn->close();
                ?>
            </tbody>
        </table>
    </div> -->











    
<style>
    body{
        overflow-y: scroll;
    }
</style>

 <?php
// Conexão com o banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>

<div class="ranking-table">
    <center><h1>Ranking de Leitores</h1></center>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Pontos</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Consultar dados de leitores e seus pontos
            $sql = "SELECT nome_exibicao, pontos 
                    FROM registrar_usuarios 
                    ORDER BY pontos DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Exibir dados na tabela
                while ($row = $result->fetch_assoc()) {
                    // Verificar se o nome está vazio e substituir por "Nome do aluno inválido"
                    $nome = !empty($row['nome_exibicao']) ? $row['nome_exibicao'] : "Nome do aluno inválido";
                    echo "<tr>
                            <td>{$nome}</td>
                            <td>{$row['pontos']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='2'>Nenhum dado encontrado</td></tr>";
            }

            // Fechar conexão
            $conn->close();
            ?>
        </tbody>
    </table>
</div>














    


    <div class="footer">
        <svg viewBox="0 0 869 344" xmlns="http://www.w3.org/2000/svg">
            <path d="M 272 0.0130308C 164.8 1.21303 46 85.1797 0 127.013L 0 342.013L 867 342.013L 867 6.51303C 779 0.013031 684.5 127.013 616.5 127.013C 548.5 127.013 406 -1.48697 272 0.0130308Z"/>
        </svg>
    </div>
</body>
</html>
