<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliotec</title>
    <link rel="shortcut icon" href="img/logo.png">
    <?php include 'conexao.php';?>
    
</head>

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

                        .title{
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            position: absolute;
                            width: 1400px;
                            background-color: #fff;
                            height: 50px;
                            top: 20%;
                            left: 50%;
                            transform: translate(-50%,-50%);
                            color: #000;
                            -webkit-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                            -moz-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                            box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                            border-radius: 3px;
                        }

                        .container{
                            padding: 20px;
                            display: flex;
                            width: 70vw;
                            height: 50vh;
                            position: absolute;
                            top: 55%;
                            left: 50%;
                            transform: translate(-50%,-50%);
                            align-items: center;
                        }


                        .dados{
                            background-color: #fff;
                            height: 350px;
                            width: 300px;
                            justify-content: center;
                            font-size: 10px;
                            text-align: left;
                            align-items: center;
                            display: flex;
                            padding-top: 90px;
                            color: #252527;
                            -webkit-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                            -moz-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                            box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                        }
                        .emp{
                            width: 100px;
                            position: absolute;
                            display: flex;
                            top: 20%;
                        }


                        .principal{
                            width: 100vw;
                            height: 100vh;  
                            display: fixed;

                        }
                    </style>


        <?php
            if ($conn->connect_error) {
                die("Falha na conexão: " . $conn->connect_error);
            }
                    
            if ($conn->connect_error) {
                die("Erro de conexão: " . $conn->connect_error);
            }
            
            // Consulta para contar o número de linhas na tabela
            $sql = "SELECT COUNT(*) AS quantidade_livros FROM livros;";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                // Exibir o número de linhas na tabela
                $row = $result->fetch_assoc();
                $total_livros = $row["quantidade_livros"];
                
            } else {
                echo "0";
            }
         ?>
        <?php
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta para contar o número de livros alugados
$sql = "SELECT COUNT(*) AS quantidade_livros_alugados FROM livros WHERE status_livros = 1;";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $total_livros_alugados = $row["quantidade_livros_alugados"];
    echo "Total de livros alugados: " . $total_livros_alugados;
} else {
    echo "Erro na consulta: " . $conn->error;
}
?>



        <?php
            if ($conn->connect_error) {
                die("Falha na conexão: " . $conn->connect_error);
            }
                    
            if ($conn->connect_error) {
                die("Erro de conexão: " . $conn->connect_error);
            }
            
            // Consulta para contar o número de linhas na tabela
            $sql = "SELECT COUNT(*) AS quantidade_leitor FROM leitor;";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                // Exibir o número de linhas na tabela
                $row = $result->fetch_assoc();
                $total_leitor = $row["quantidade_leitor"];
                
            } else {
                echo "0";
            }
         ?>

        <?php
            if ($conn->connect_error) {
                die("Falha na conexão: " . $conn->connect_error);
            }
                    
            if ($conn->connect_error) {
                die("Erro de conexão: " . $conn->connect_error);
            }
            
            // Consulta para contar o número de linhas na tabela
            $sql = "SELECT COUNT(*) AS quantidade_artigo FROM artigo;";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                // Exibir o número de linhas na tabela
                $row = $result->fetch_assoc();
                $total_artigo = $row["quantidade_artigo"];
                
            } else {
                echo "0";
            }
         ?>

<body>
    <div class="principal">
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
    <div class="title">
        <h1>SISTEMA BIBLIOTEC</h1>
    </div>
<div class="container">
    <div class="dados">
        <img src="img/livros.png" alt="" class="emp">
        <h1>LIVROS CADASTRADOS <br> <br>TOTAL:<?php echo " ".$total_livros ?></h1>
    </div>

    <div class="dados">
        <img src="img/relogio.png" alt=""  class="emp">
        <h1>LIVROS EMPRESTADOS <br> <br>TOTAL:<?php echo " ".$total_livros_alugados ?></h1>
    </div>

    <div class="dados">
        <img src="img/alunos.png" alt=""  class="emp">
        <h1>LEITORES CADASTRADOS <br> <br>TOTAL:<?php echo " ".$total_leitor ?></h1>
    </div>

    <div class="dados">
        <img src="img/tcc.png" alt=""  class="emp">
        <h1>TCC's CADASTRADOS<br> <br>TOTAL:<?php echo " ".$total_artigo ?></h1>
    </div>
        
    
        
</div>
</div>


</body>
</html>
