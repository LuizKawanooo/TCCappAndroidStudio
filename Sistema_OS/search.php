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
$codigo_cliente = isset($_GET['codigo_cliente']) ? $_GET['codigo_cliente'] : '';
$aparelho = isset($_GET['aparelho']) ? $_GET['aparelho'] : '';
$marca = isset($_GET['marca']) ? $_GET['marca'] : '';
$modelo = isset($_GET['modelo']) ? $_GET['modelo'] : '';
$serie = isset($_GET['serie']) ? $_GET['serie'] : '';
$entrega = isset($_GET['entrega']) ? $_GET['entrega'] : '';

// Monta a query de busca com base nos parâmetros fornecidos
$sql = "SELECT * FROM ordem_servico WHERE 1=1"; // A cláusula WHERE 1=1 facilita a adição de outras condições

if (!empty($codigo_cliente)) {
    $sql .= " AND codigo_cliente LIKE :codigo_cliente";
}
if (!empty($aparelho)) {
    $sql .= " AND aparelho LIKE :aparelho";
}
if (!empty($marca)) {
    $sql .= " AND marca LIKE :marca";
}
if (!empty($modelo)) {
    $sql .= " AND modelo LIKE :modelo";
}
if (!empty($serie)) {
    $sql .= " AND serie LIKE :serie";
}
if (!empty($entrega)) {
    $sql .= " AND entrega LIKE :entrega";
}

// Prepara e executa a consulta
$stmt = $pdo->prepare($sql);

if (!empty($codigo_cliente)) {
    $stmt->bindValue(':codigo_cliente', '%' . $codigo_cliente . '%');
}
if (!empty($aparelho)) {
    $stmt->bindValue(':aparelho', '%' . $aparelho . '%');
}
if (!empty($marca)) {
    $stmt->bindValue(':marca', '%' . $marca . '%');
}
if (!empty($modelo)) {
    $stmt->bindValue(':modelo', '%' . $modelo . '%');
}
if (!empty($serie)) {
    $stmt->bindValue(':serie', '%' . $serie . '%');
}
if (!empty($entrega)) {
    $stmt->bindValue(':entrega', '%' . $entrega . '%');
}

$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Exibe os resultados da pesquisa
if ($results) {
    echo '<div class="search-results">';
    foreach ($results as $row) {
        echo "<div class='result-item'>";
        echo "Código Cliente: " . htmlspecialchars($row['codigo_cliente']) . "<br>";
        echo "Aparelho: " . htmlspecialchars($row['aparelho']) . "<br>";
        echo "Marca: " . htmlspecialchars($row['marca']) . "<br>";
        echo "Modelo: " . htmlspecialchars($row['modelo']) . "<br>";
        echo "Série: " . htmlspecialchars($row['serie']) . "<br>";
        echo "Entrega: " . htmlspecialchars($row['entrega']) . "<br>";
        echo "</div>";
    }
    echo '</div>';
} else {
    echo "Nenhum resultado encontrado.";
}
?>
