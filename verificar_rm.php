<?php
include 'conexao.php';

$rm = $_POST['rm'];

// Consulta SQL para verificar se o RM está cadastrado no banco de dados
$sql = "SELECT * FROM estudante WHERE cod_rm = '$rm'";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    // RM encontrado, redireciona para página de redefinição de senha
    header("Location: EsqueciMinhaSenha.php?rm=$rm");
} else {
    // RM não encontrado, redireciona para página de cadastro
    header("Location: Cadastro.java");
}

mysqli_close($con);
?>
