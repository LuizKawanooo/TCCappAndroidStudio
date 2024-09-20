<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO bibliotecario (email, password) VALUES (?, ?)");
    
    if ($stmt === false) {
        die("Erro na preparação da consulta SQL: " . $conn->error);
    }

    $stmt->bind_param("ss", $email, $password);

    if ($stmt->execute()) {
        echo "<p style='color:#2ACA22; z-index: 1; font-size:20px; position: absolute; top: 58%; left: 50%; transform:translate(-50%, -50%);'>Usuário cadastrado com sucesso.</p>";
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bibliotec - Registro</title>
    <link rel="shortcut icon" href="img/logo.png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap');

        body {
            background-image: linear-gradient(to right, #30cfd0 0%, #330867 100%);
            overflow: hidden;
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

        .container {
            background-color: rgb(255,255,255,0.6);
            height: 300px;
            width: 600px;
            border-radius: 9px;
            position: absolute;
            justify-content: center;
            text-align: center;
            align-items: center;
            backdrop-filter: blur(10px);
            color: #252527;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -webkit-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
            -moz-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
            box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
        }
        .copy-btn {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #008CBA;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .copy-btn:hover {
            background-color: #007B9E;
        }

        input {
            height: 30px;
            width: 300px;
            flex: 1;
            padding-left: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .solicita {
            font-family: Roboto, sans-serif;
            width: 200px;
            height: 50px;
            font-size: 13px;
            color: #fff;
            background-color: #330867;
            border: none;
            -webkit-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
            -moz-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
            box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
            border-radius: 50px;
            position: absolute;
            align-items: center;
            cursor: pointer;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }


        .inp1 {
            width: 100px;
            padding-left: 46px;
            text-align: left;
        }

        .inp2 {
            width: 100px;
            padding-left: 46px;
            text-align: left;
        }

        p{
            font-style: italic;
        }

        a {
            position: absolute;
            top: 93%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

       
        .title {
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

        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            height: 750px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 80px rgba(0, 0, 0, 0.4);
            z-index: 1000;
            padding: 20px;
            text-align: center;
        }
        
        
        .popup h1 {
            font-size: 24px;
        }

        .popup button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #005aeb;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .popup button.close {
            background-color: #ff0000;
            
        }

    </style>
</head>
<body>

    <div id="popup" class="popup">
        <h1>Solicitar Registro</h1>
        <form method="post" action="register.php">
    <br>
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
<br>
        <label for="posicao">Posição ou Função:</label>
        <input type="text" id="posicao" name="posicao" required>
<br>
        <label for="nome_escola">Nome da Escola:</label>
        <input type="text" id="nome_escola" name="nome_escola" required>
<br>
        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco" required>
<br>
        <label for="telefone">Telefone:</label>
        <input type="tel" id="telefone" name="telefone" required>
<br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
<br>
        <button type="submit">Registrar</button>
        <button type="button" class="copy-btn" onclick="copyEmail()">Copiar E-mail</button>
    </form>
        <button class="close" onclick="closePopup()">Fechar</button>
    </div>

    <?php
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

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $conn->real_escape_string($_POST['nome']);
    $posicao = $conn->real_escape_string($_POST['posicao']);
    $nome_escola = $conn->real_escape_string($_POST['nome_escola']);
    $endereco = $conn->real_escape_string($_POST['endereco']);
    $telefone = $conn->real_escape_string($_POST['telefone']);
    $email = $conn->real_escape_string($_POST['email']);

    // Consulta para inserir os dados
    $sql = "INSERT INTO registro (nome, posicao, nome_escola, endereco, telefone, email) VALUES ('$nome', '$posicao', '$nome_escola', '$endereco', '$telefone', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "Registro criado com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>


    <div class="title">
        <h1>SISTEMA BIBLIOTEC</h1>
    </div>

    <div class="footer">
        <svg viewBox="0 0 869 344" xmlns="http://www.w3.org/2000/svg">
            <path d="M 272 0.0130308C 164.8 1.21303 46 85.1797 0 127.013L 0 342.013L 867 342.013L 867 6.51303C 779 0.013031 684.5 127.013 616.5 127.013C 548.5 127.013 406 -1.48697 272 0.0130308Z"/>
        </svg>
    </div>

    <form method="post" action="register.php" class="container">
        <a href="login.php">Já tenho cadastro</a>
        <div class="solicita" id="openPopup">
            <h3>Solicitar registro</h3>
        </div>
    </form>

    <script>
        document.getElementById('openPopup').addEventListener('click', function() {
            document.getElementById('popup').style.display = 'block';
        });

        function closePopup() {
            document.getElementById('popup').style.display = 'none';
        }

        function copyEmail() {
            var emailField = document.getElementById('emailField');
            emailField.select();
            document.execCommand('copy');
            alert('E-mail copiado para a área de transferência!');
        }
    </script>

</body> 
</html>
