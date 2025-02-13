// Conexão com o banco de dados
$host = 'bd-os-endo.mysql.uhserver.com';  // Ajuste para o seu host
$user = 'joseendologic';  // Ajuste para seu usuário
$password = '{[OSluiz2019';  // Ajuste para sua senha
$dbname = 'bd_os_endo';  // Ajuste para o nome do seu banco de dados

$conn = new mysqli($host, $user, $password, $dbname);

// Verifique se houve algum erro de conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Pegando os valores dos campos de pesquisa
$noOrdem = isset($_GET['no_ordem']) ? $_GET['no_ordem'] : '';
$dataOrdem = isset($_GET['data_ordem']) ? $_GET['data_ordem'] : '';
$razaoOrdem = isset($_GET['razao_ordem']) ? $_GET['razao_ordem'] : '';
$serieOrdem = isset($_GET['serie_ordem']) ? $_GET['serie_ordem'] : '';
$entregarOrdem = isset($_GET['entregar_ordem']) ? $_GET['entregar_ordem'] : '';

// Iniciar a consulta SQL
$query = "SELECT * FROM ordem_servico WHERE 1=1";  // A consulta começa com WHERE 1=1 para adicionar as condições facilmente

// Adicionando condições se os campos não estão vazios
if (!empty($noOrdem)) {
    $query .= " AND no_ordem = '$noOrdem'";
}
if (!empty($dataOrdem)) {
    $query .= " AND data_ordem = '$dataOrdem'";
}
if (!empty($razaoOrdem)) {
    $query .= " AND razao_ordem LIKE '%$razaoOrdem%'";
}
if (!empty($serieOrdem)) {
    $query .= " AND serie_ordem = '$serieOrdem'";
}
if (!empty($entregarOrdem)) {
    $query .= " AND entregar_ordem = '$entregarOrdem'";
}

// Executando a consulta
$result = $conn->query($query);

// Verificando se há resultados
if ($result->num_rows > 0) {
    // Imprimir os resultados em formato de tabela
    echo '<div class="search-result-row">';
    echo '<div class="search-result-header">No. Ordem</div>';
    echo '<div class="search-result-header">Data Ordem</div>';
    echo '<div class="search-result-header">Razão Social</div>';
    echo '<div class="search-result-header">Série</div>';
    echo '<div class="search-result-header">Data Entrega</div>';
    echo '</div>';
    
    // Imprimir cada linha de resultado
    while ($row = $result->fetch_assoc()) {
        echo '<div class="search-result-row">';
        echo '<div class="search-result-cell">' . htmlspecialchars($row['no_ordem']) . '</div>';
        echo '<div class="search-result-cell">' . htmlspecialchars($row['data_ordem']) . '</div>';
        echo '<div class="search-result-cell">' . htmlspecialchars($row['razao_ordem']) . '</div>';
        echo '<div class="search-result-cell">' . htmlspecialchars($row['serie_ordem']) . '</div>';
        echo '<div class="search-result-cell">' . htmlspecialchars($row['entregar_ordem']) . '</div>';
        echo '</div>';
    }
} else {
    echo '<p>Nenhum resultado encontrado.</p>';
}

// Fechar a conexão com o banco de dados
$conn->close();
?>
