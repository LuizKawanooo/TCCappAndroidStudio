<?php
// Ativar exibição de erros
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Configurar o tipo de conteúdo como JSON
header('Content-Type: application/json');

// Configurações de conexão com o banco de dados
$host = 'bd-os-endo.mysql.uhserver.com'; // Altere para seu host
$dbname = 'bd_os_endo'; // Altere para seu banco de dados
$user = 'joseendologic'; // Altere para o seu usuário
$pass = '{[OSluiz2019'; // Altere para a sua senha

// Conectar ao banco de dados
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Captura dos parâmetros de pesquisa da URL
    $no_ordem = $_GET['no_ordem'] ?? '';
    $data_ordem = $_GET['data_ordem'] ?? '';
    $razao_ordem = $_GET['razao_ordem'] ?? '';
    $serie_ordem = $_GET['serie_ordem'] ?? '';
    $entregar_ordem = $_GET['entregar_ordem'] ?? '';

    // Construir consulta SQL com base nos parâmetros recebidos
    $query = "SELECT * FROM sua_tabela WHERE 1=1"; // Altere 'sua_tabela' para o nome correto da sua tabela

    // Adicionando condições à consulta dependendo dos parâmetros de pesquisa
    if ($no_ordem) $query .= " AND no_ordem LIKE '%$no_ordem%'";
    if ($data_ordem) $query .= " AND data_ordem LIKE '%$data_ordem%'";
    if ($razao_ordem) $query .= " AND razao_ordem LIKE '%$razao_ordem%'";
    if ($serie_ordem) $query .= " AND serie_ordem LIKE '%$serie_ordem%'";
    if ($entregar_ordem) $query .= " AND entregar_ordem LIKE '%$entregar_ordem%'";

    // Preparar e executar a consulta
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    // Buscar os resultados
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retornar os dados em formato JSON
    echo json_encode($result);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Erro de conexão: ' . $e->getMessage()]);
}
?>

