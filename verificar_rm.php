// <?php
// include 'conexao.php';

// $rm = $_POST['rm'];

// // Consulta SQL para verificar se o RM está cadastrado no banco de dados
// $sql = "SELECT * FROM estudante WHERE cod_rm = '$rm'";
// $result = mysqli_query($con, $sql);

// if (mysqli_num_rows($result) > 0) {
//     // RM encontrado, redireciona para página de redefinição de senha
//     header("Location: EsqueciMinhaSenha.php?rm=$rm");
// } else {
//     // RM não encontrado, redireciona para página de cadastro
//     header("Location: Cadastro.java");
// }

// mysqli_close($con);
// ?>






<?php
include 'conexao.php';

$rm = $_POST['rm'];

// Verifica se o RM foi fornecido
if (empty($rm)) {
    header("Location: Cadastro.php"); // Redireciona para a página de cadastro se RM não for fornecido
    exit();
}

try {
    // Prepara a consulta SQL para verificar se o RM está cadastrado
    $stmt = $con->prepare("SELECT * FROM estudante WHERE cod_rm = ?");
    $stmt->bind_param("s", $rm); // "s" significa que estamos esperando uma string

    // Executa a consulta
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // RM encontrado, redireciona para página de redefinição de senha
        header("Location: EsqueciMinhaSenha.php?rm=$rm");
    } else {
        // RM não encontrado, redireciona para página de cadastro
        header("Location: Cadastro.php"); // Corrija o nome do arquivo se necessário
    }

    // Fecha a consulta
    $stmt->close();
} catch (Exception $e) {
    // Tratamento de erro
    echo "Erro ao consultar o RM: " . $e->getMessage();
} finally {
    // Fecha a conexão
    $con->close();
}
?>
