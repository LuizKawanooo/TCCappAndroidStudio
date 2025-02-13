<?php
header('Content-Type: application/json');
include 'conexao.php'; // Conexão com o banco de dados

// Receber os parâmetros da pesquisa
$noOrdem = isset($_GET['noOrdem']) ? $_GET['noOrdem'] : '';
$dataOrdem = isset($_GET['dataOrdem']) ? $_GET['dataOrdem'] : '';
$razaoOrdem = isset($_GET['razaoOrdem']) ? $_GET['razaoOrdem'] : '';
$serieOrdem = isset($_GET['serieOrdem']) ? $_GET['serieOrdem'] : '';
$entregarOrdem = isset($_GET['entregarOrdem']) ? $_GET['entregarOrdem'] : '';

// Criar a consulta dinâmica
$query = "SELECT * FROM ordem_servico WHERE 1=1";

if ($noOrdem != '') {
    $query .= " AND id = '$noOrdem'";
}
if ($dataOrdem != '') {
    $query .= " AND data_registro = '$dataOrdem'";
}
if ($razaoOrdem != '') {
    $query .= " AND razao_social LIKE '%$razaoOrdem%'";
}
if ($serieOrdem != '') {
    $query .= " AND serie LIKE '%$serieOrdem%'";
}
if ($entregarOrdem != '') {
    $query .= " AND data_entrega = '$entregarOrdem'";
}

$result = mysqli_query($conexao, $query);

// Armazenar os resultados em um array
$ordens = array();
while ($row = mysqli_fetch_assoc($result)) {
    $ordens[] = $row;
}

// Retornar os resultados como JSON
echo json_encode($ordens);

mysqli_close($conexao);
?>
