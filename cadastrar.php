<?php

include("conexao.php");

// Verifica se a requisição é do tipo POST ou GET
if ($_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "GET") {
    // Obtém os dados do formulário
    $CodEtecAPI = $_REQUEST['txtcodetec'] ?? '';
    $EmailAPI = $_REQUEST['txtemail'] ?? '';
    $RMAPI = $_REQUEST['txtrm'] ?? '';
    $SenhaAPI = $_REQUEST['txtsenha'] ?? '';

 // Prepara a consulta de inserção SQL
 $sql = "INSERT INTO estudante (ID_colegio, Email, cod_rm, senha) VALUES (?, ?, ?, ?)";
 $stmt = mysqli_prepare($con, $sql);

    // Verifica se a preparação da consulta foi bem-sucedida
    if ($stmt) {
        // Vincula os parâmetros
        mysqli_stmt_bind_param($stmt, "isis", $CodEtecAPI, $EmailAPI, $RMAPI, $SenhaAPI);
        
        // Executa a consulta
        $resultado = mysqli_stmt_execute($stmt);
        
        // Verifica se a inserção foi bem-sucedida
        if ($resultado) {
            echo json_encode(array('success' => true, 'message' => 'Usuário cadastrado com sucesso!'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Erro ao cadastrar o usuário: ' . mysqli_error($con)));
        }
        
        // Fecha a declaração
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(array('success' => false, 'message' => 'Erro na preparação da query: ' . mysqli_error($con)));
    }

    // Fecha a conexão com o banco de dados
    mysqli_close($con);
} else {
    // Se a requisição não for do tipo POST ou GET, retorna uma mensagem de erro
    echo json_encode(array('success' => false, 'message' => 'Método inválido. Este script aceita apenas requisições POST ou GET.'));
}

?>
