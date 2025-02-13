<?php
header('Content-Type: application/json');

// Conexão com o banco de dados
$host = 'bd-os-endo.mysql.uhserver.com';  // Substitua pelo seu host, se necessário
$dbname = 'bd_os_endo';
$username = 'joseendologic';
$password = '{[OSluiz2019}';

$conexao = new mysqli($host, $username, $password, $dbname);

// Verificar se a conexão foi bem-sucedida
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

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

$result = $conexao->query($query);

// Armazenar os resultados em um array
$ordens = array();
while ($row = $result->fetch_assoc()) {
    $ordens[] = $row;
}

// Retornar os resultados como JSON
echo json_encode($ordens);

// Fechar a conexão
$conexao->close();
?>
