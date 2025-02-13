<?php
// Habilitando a exibição de erros para facilitar a depuração
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Conexão com o banco de dados
$host = 'bd-os-endo.mysql.uhserver.com'; // seu host
$dbname = 'tccappionic_bd'; // nome do banco de dados
$username = 'ionic_perfil_bd'; // seu usuário do banco de dados
$password = '{[OSluiz2019'; // sua senha do banco de dados

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erro de conexão: ' . $e->getMessage();
    exit;
}

// Inicializando os parâmetros da consulta
$no_ordem = isset($_GET['no_ordem']) ? $_GET['no_ordem'] : '';
$data_ordem = isset($_GET['data_ordem']) ? $_GET['data_ordem'] : '';
$razao_ordem = isset($_GET['razao_ordem']) ? $_GET['razao_ordem'] : '';
$serie_ordem = isset($_GET['serie_ordem']) ? $_GET['serie_ordem'] : '';
$entregar_ordem = isset($_GET['entregar_ordem']) ? $_GET['entregar_ordem'] : '';

// Criando a consulta SQL com base nos parâmetros
$query = "SELECT * FROM ordem_servico WHERE 1=1";

if ($no_ordem) $query .= " AND no_ordem LIKE :no_ordem";
if ($data_ordem) $query .= " AND data_ordem LIKE :data_ordem";
if ($razao_ordem) $query .= " AND razao_ordem LIKE :razao_ordem";
if ($serie_ordem) $query .= " AND serie_ordem LIKE :serie_ordem";
if ($entregar_ordem) $query .= " AND entregar_ordem LIKE :entregar_ordem";

// Preparando a consulta
$stmt = $pdo->prepare($query);

// Ligando os parâmetros dinamicamente
if ($no_ordem) $stmt->bindValue(':no_ordem', '%' . $no_ordem . '%');
if ($data_ordem) $stmt->bindValue(':data_ordem', '%' . $data_ordem . '%');
if ($razao_ordem) $stmt->bindValue(':razao_ordem', '%' . $razao_ordem . '%');
if ($serie_ordem) $stmt->bindValue(':serie_ordem', '%' . $serie_ordem . '%');
if ($entregar_ordem) $stmt->bindValue(':entregar_ordem', '%' . $entregar_ordem . '%');

// Executando a consulta
$stmt->execute();

// Verificando se há resultados
if ($stmt->rowCount() > 0) {
    // Exibindo os resultados em formato HTML
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        echo '<td>' . $row['no_ordem'] . '</td>';
        echo '<td>' . $row['data_ordem'] . '</td>';
        echo '<td>' . $row['razao_ordem'] . '</td>';
        echo '<td>' . $row['serie_ordem'] . '</td>';
        echo '<td>' . $row['entregar_ordem'] . '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="5">Nenhum resultado encontrado</td></tr>';
}

?>
