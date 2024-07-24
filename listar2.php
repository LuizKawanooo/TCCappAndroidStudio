<?php
include 'conexao.php';

// Inicializa a lista de estudantes
$lista = array();

// Consulta para selecionar todos os registros da tabela "estudante"
$sql = "SELECT * FROM estudante";

// Executa a consulta
$resultado = mysqli_query($con, $sql);

// Verifica se a consulta foi bem-sucedida
if ($resultado) {
    // Percorre os resultados e adiciona cada estudante à lista
    while ($estudante = mysqli_fetch_assoc($resultado)) {
        $lista[] = $estudante;
    }
    
    // Libera a memória associada ao resultado da consulta
    mysqli_free_result($resultado);
    
    // Fecha a conexão com o banco de dados
    mysqli_close($con);
    
    // Retorna a lista de estudantes como JSON
    echo json_encode($lista);
} else {
    // Se a consulta falhar, retorna uma mensagem de erro
    http_response_code(500); // Código de status HTTP 500 (Internal Server Error)
    echo "Erro ao executar a consulta ao banco de dados.";
}
?>
