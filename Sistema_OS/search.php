<?php
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
$codigoCliente = isset($_GET['codigo_cliente']) ? $_GET['codigo_cliente'] : '';
$aparelho = isset($_GET['aparelho']) ? $_GET['aparelho'] : '';
$marca = isset($_GET['marca']) ? $_GET['marca'] : '';
$modelo = isset($_GET['modelo']) ? $_GET['modelo'] : '';
$serie = isset($_GET['serie']) ? $_GET['serie'] : '';
$acessorios = isset($_GET['acessorios']) ? $_GET['acessorios'] : '';
$condicoes = isset($_GET['condicoes']) ? $_GET['condicoes'] : '';
$defeitoInformado = isset($_GET['defeito_informado']) ? $_GET['defeito_informado'] : '';
$descricaoServico = isset($_GET['descricao_servico']) ? $_GET['descricao_servico'] : '';
$dataEntrega = isset($_GET['data_entrega']) ? $_GET['data_entrega'] : '';

// Iniciar a consulta SQL
$query = "SELECT * FROM ordem_servico WHERE 1=1";  // A consulta começa com WHERE 1=1 para adicionar as condições facilmente

// Adicionando condições se os campos não estão vazios
if (!empty($codigoCliente)) {
    $query .= " AND codigo_cliente = '$codigoCliente'";
}
if (!empty($aparelho)) {
    $query .= " AND aparelho LIKE '%$aparelho%'";
}
if (!empty($marca)) {
    $query .= " AND marca LIKE '%$marca%'";
}
if (!empty($modelo)) {
    $query .= " AND modelo LIKE '%$modelo%'";
}
if (!empty($serie)) {
    $query .= " AND serie = '$serie'";
}
if (!empty($acessorios)) {
    $query .= " AND acessorios LIKE '%$acessorios%'";
}
if (!empty($condicoes)) {
    $query .= " AND condicoes LIKE '%$condicoes%'";
}
if (!empty($defeitoInformado)) {
    $query .= " AND defeito_informado LIKE '%$defeitoInformado%'";
}
if (!empty($descricaoServico)) {
    $query .= " AND descricao_servico LIKE '%$descricaoServico%'";
}
if (!empty($dataEntrega)) {
    $query .= " AND data_entrega = '$dataEntrega'";
}

// Executando a consulta
$result = $conn->query($query);

// Verificando se há resultados
if ($result->num_rows > 0) {
    // Imprimir os resultados em formato de tabela
    echo '<div class="search-result-row">';
    echo '<div class="search-result-header">Código Cliente</div>';
    echo '<div class="search-result-header">Aparelho</div>';
    echo '<div class="search-result-header">Marca</div>';
    echo '<div class="search-result-header">Modelo</div>';
    echo '<div class="search-result-header">Série</div>';
    echo '<div class="search-result-header">Acessórios</div>';
    echo '<div class="search-result-header">Condições</div>';
    echo '<div class="search-result-header">Defeito Informado</div>';
    echo '<div class="search-result-header">Descrição do Serviço</div>';
    echo '<div class="search-result-header">Data de Entrega</div>';
    echo '</div>';
    
    // Imprimir cada linha de resultado
    while ($row = $result->fetch_assoc()) {
        echo '<div class="search-result-row">';
        echo '<div class="search-result-cell">' . htmlspecialchars($row['codigo_cliente']) . '</div>';
        echo '<div class="search-result-cell">' . htmlspecialchars($row['aparelho']) . '</div>';
        echo '<div class="search-result-cell">' . htmlspecialchars($row['marca']) . '</div>';
        echo '<div class="search-result-cell">' . htmlspecialchars($row['modelo']) . '</div>';
        echo '<div class="search-result-cell">' . htmlspecialchars($row['serie']) . '</div>';
        echo '<div class="search-result-cell">' . htmlspecialchars($row['acessorios']) . '</div>';
        echo '<div class="search-result-cell">' . htmlspecialchars($row['condicoes']) . '</div>';
        echo '<div class="search-result-cell">' . htmlspecialchars($row['defeito_informado']) . '</div>';
        echo '<div class="search-result-cell">' . htmlspecialchars($row['descricao_servico']) . '</div>';
        echo '<div class="search-result-cell">' . htmlspecialchars($row['data_entrega']) . '</div>';
        echo '</div>';
    }
} else {
    echo '<p>Nenhum resultado encontrado.</p>';
}

// Fechar a conexão com o banco de dados
$conn->close();
?>
