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

// Pega o valor da pesquisa via GET
$query = isset($_GET['q']) ? $_GET['q'] : '';

// Se o valor de pesquisa estiver vazio, retorna
if (empty($query)) {
    exit;
}

// Consulta o banco de dados para encontrar registros que correspondam à pesquisa
$stmt = $pdo->prepare("SELECT * FROM aparelhos WHERE nome LIKE :query LIMIT 5");
$stmt->execute(['query' => '%' . $query . '%']);

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Se houver resultados, exibe-os, caso contrário, exibe uma mensagem
if ($results) {
    foreach ($results as $row) {
        echo "<div>" . htmlspecialchars($row['nome']) . "</div>"; // Exibe o nome do aparelho encontrado
    }
} else {
    echo "Nenhum resultado encontrado.";
}
?>
