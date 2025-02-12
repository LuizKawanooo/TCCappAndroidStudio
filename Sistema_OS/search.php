<?php
// Configurações do banco de dados
$host = 'bd-os-endo.mysql.uhserver.com'; // ou o endereço do seu banco
$dbname = 'bd_os_endo';
$username = 'joseendologic';
$password = '{[OSluiz2019';

// Conectar ao banco de dados
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erro: ' . $e->getMessage();
    exit;
}

// Pega os valores de pesquisa via GET
$no_ordem = isset($_GET['no_ordem']) ? $_GET['no_ordem'] : '';
$data_ordem = isset($_GET['data_ordem']) ? $_GET['data_ordem'] : '';
$razao_ordem = isset($_GET['razao_ordem']) ? $_GET['razao_ordem'] : '';
$serie_ordem = isset($_GET['serie_ordem']) ? $_GET['serie_ordem'] : '';
$entregar_ordem = isset($_GET['entregar_ordem']) ? $_GET['entregar_ordem'] : '';

// Monta a query de busca com base nos parâmetros fornecidos
$sql = "SELECT * FROM ordens WHERE 1=1"; // A cláusula WHERE 1=1 facilita a adição de outras condições

if (!empty($no_ordem)) {
    $sql .= " AND no_ordem LIKE :no_ordem";
}
if (!empty($data_ordem)) {
    $sql .= " AND data_ordem LIKE :data_ordem";
}
if (!empty($razao_ordem)) {
    $sql .= " AND razao_ordem LIKE :razao_ordem";
}
if (!empty($serie_ordem)) {
    $sql .= " AND serie_ordem LIKE :serie_ordem";
}
if (!empty($entregar_ordem)) {
    $sql .= " AND entregar_ordem LIKE :entregar_ordem";
}

// Prepara e executa a consulta
$stmt = $pdo->prepare($sql);

if (!empty($no_ordem)) {
    $stmt->bindValue(':no_ordem', '%' . $no_ordem . '%');
}
if (!empty($data_ordem)) {
    $stmt->bindValue(':data_ordem', '%' . $data_ordem . '%');
}
if (!empty($razao_ordem)) {
    $stmt->bindValue(':razao_ordem', '%' . $razao_ordem . '%');
}
if (!empty($serie_ordem)) {
    $stmt->bindValue(':serie_ordem', '%' . $serie_ordem . '%');
}
if (!empty($entregar_ordem)) {
    $stmt->bindValue(':entregar_ordem', '%' . $entregar_ordem . '%');
}

$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Exibe os resultados da pesquisa
if ($results) {
    foreach ($results as $row) {
        echo "<div>Ord. No: " . htmlspecialchars($row['no_ordem']) . " - " . htmlspecialchars($row['razao_ordem']) . " - " . htmlspecialchars($row['serie_ordem']) . "</div>";
    }
} else {
    echo "Nenhum resultado encontrado.";
}
?>
