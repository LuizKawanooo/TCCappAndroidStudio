<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliotec - artigos</title>
    <link rel="shortcut icon" href="img/logo.png">
</head>
<body>

<?php
        session_start();
        include 'conexao.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $stmt = $conn->prepare("SELECT ID_bibliotecario, password FROM bibliotecario WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $hashed_password);
            $stmt->fetch();

            if ($stmt->num_rows == 1 && password_verify($password, $hashed_password)) {
                  
                header("Location: inicio.php");
            } else {
                echo "<p style='color:#f00; font-size:20px; position: absolute; top: 58%; left: 50%; transform:translate(-50%, -50%);'>Email ou senha inválidos.</p>";
            }

            $stmt->close();
            $conn->close();
        }
        ?>

        <style>
                
                
            @import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap');

            body{
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
            .container{
                background-color: rgb(255,255,255,0.6);
                height: 550px;
                width: 400px;
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
            input{
                height: 30px;
                width: 300px;
                flex: 1;
                padding-left: 5px;
                border: 1px solid #ccc;
                border-radius: 5px;
                border: none;
                outline: none;
            }
            
            .btn{
                font-family: Roboto, sans-serif;
                width: 150px;
                font-weight: 0;
                font-size: 14px;
                color: #fff;
                background-color: #330867;
                border: none;
                -webkit-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                -moz-box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                box-shadow: 2px 11px 31px -10px rgba(0,0,0,0.6);
                border-radius: 50px;
                margin-top: 50px;
                flex-direction: row;
                align-items: center;
                cursor: pointer;
                
            }
            p{
                font-size: 20px;
            }
            h1{
                font-size: 40px;
            }
            .inp1{
                width: 100px;
                padding-left: 46px;
                text-align: left;
            }
            .inp2{
                width: 100px;
                padding-left: 46px;
                text-align: left;
            }
            a{
                position: absolute;
                top: 93%;
                left: 50%;
                transform: translate(-50%, -50%);
                
            }
        </style>

        <div class="footer">
            <svg viewBox="0 0 869 344" xmlns="http://www.w3.org/2000/svg">
                <path d="M 272 0.0130308C 164.8 1.21303 46 85.1797 0 127.013L 0 342.013L 867 342.013L 867 6.51303C 779 0.013031 684.5 127.013 616.5 127.013C 548.5 127.013 406 -1.48697 272 0.0130308Z"/>
            </svg>
        </div>


    
        <form method="post" action="login.php" class="container">
            <h1>LOGIN</h1>
            <div class="inp1"><p>Usuário:</p> <input type="text" name="email" required placeholder="Digite seu usuário"><br></div>
            <div class="inp2"><p>Senha:</p> <input type="password" name="password" required placeholder="Digite sua senha"><br></div>
        
            <a href="register.php">Não tenho cadastro</a>
            <input type="submit" value="Login" class="btn">
        </form>
    

    
</body>
</html>
