<?php
// Conexão com o banco de dados
$host = 'bd-os-endo.mysql.uhserver.com';
$user = 'joseendologic';
$password = '{[OSluiz2019';
$dbname = 'bd_os_endo';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Coletando os parâmetros da URL
$no_ordem = isset($_GET['no_ordem']) ? $_GET['no_ordem'] : '';
$data_ordem = isset($_GET['data_ordem']) ? $_GET['data_ordem'] : '';
$razao_ordem = isset($_GET['razao_ordem']) ? $_GET['razao_ordem'] : '';
$serie_ordem = isset($_GET['serie_ordem']) ? $_GET['serie_ordem'] : '';
$entregar_ordem = isset($_GET['entregar_ordem']) ? $_GET['entregar_ordem'] : '';

// Construindo a consulta SQL com base nos parâmetros fornecidos
$query = "SELECT * FROM sua_tabela WHERE 1=1";

if ($no_ordem != '') {
    $query .= " AND no_ordem LIKE '%$no_ordem%'";
}
if ($data_ordem != '') {
    $query .= " AND data_ordem LIKE '%$data_ordem%'";
}
if ($razao_ordem != '') {
    $query .= " AND razao_ordem LIKE '%$razao_ordem%'";
}
if ($serie_ordem != '') {
    $query .= " AND serie_ordem LIKE '%$serie_ordem%'";
}
if ($entregar_ordem != '') {
    $query .= " AND entregar_ordem LIKE '%$entregar_ordem%'";
}

$result = $conn->query($query);

// Preparando os dados para enviar ao JavaScript
$rows = [];
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

echo json_encode($rows);

// Fechando a conexão
$conn->close();
?>
