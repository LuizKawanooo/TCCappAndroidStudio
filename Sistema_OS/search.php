<?php
// Ativar a exibição de erros para facilitar o debug
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Configurar o tipo de conteúdo como JSON
header('Content-Type: application/json');

// Conectar ao banco de dados
$host = 'localhost'; // Altere para o seu host
$dbname = 'seu_banco_de_dados'; // Altere para o seu nome de banco de dados
$user = 'seu_usuario'; // Altere para o seu usuário
$pass = 'sua_senha'; // Altere para a sua senha

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Capturando os parâmetros da URL
    $no_ordem = $_GET['no_ordem'] ?? '';
    $data_ordem = $_GET['data_ordem'] ?? '';
    $razao_ordem = $_GET['razao_ordem'] ?? '';
    $serie_ordem = $_GET['serie_ordem'] ?? '';
    $entregar_ordem = $_GET['entregar_ordem'] ?? '';

    // Construção da consulta SQL com base nos parâmetros
    $query = "SELECT * FROM sua_tabela WHERE 1=1"; // Substitua 'sua_tabela' pelo nome correto da sua tabela

    if ($no_ordem) $query .= " AND no_ordem LIKE '%$no_ordem%'";
    if ($data_ordem) $query .= " AND data_ordem LIKE '%$data_ordem%'";
    if ($razao_ordem) $query .= " AND razao_ordem LIKE '%$razao_ordem%'";
    if ($serie_ordem) $query .= " AND serie_ordem LIKE '%$serie_ordem%'";
    if ($entregar_ordem) $query .= " AND entregar_ordem LIKE '%$entregar_ordem%'";

    // Preparando e executando a consulta
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Obtendo os resultados
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Enviando os resultados como resposta JSON
    echo json_encode($results);

} catch (Exception $e) {
    // Caso ocorra algum erro, enviar uma mensagem de erro em JSON
    echo json_encode(['error' => 'Erro ao buscar dados: ' . $e->getMessage()]);
}
?>
