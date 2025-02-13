<?php
// Conexão com o banco de dados
$host = 'bd-os-endo.mysql.uhserver.com';  // Ajuste para o seu host
$user = 'joseendologic';  // Ajuste para seu usuário
$password = '{[OSluiz2019';  // Ajuste para sua senha
$dbname = 'bd_os_endo';  // Ajuste para o nome do seu banco de dados

// Estabelecendo a conexão
$conn = new mysqli($host, $user, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obtendo os parâmetros da URL (search query)
$no_ordem = isset($_GET['no_ordem']) ? $_GET['no_ordem'] : '';
$data_ordem = isset($_GET['data_ordem']) ? $_GET['data_ordem'] : '';
$razao_ordem = isset($_GET['razao_ordem']) ? $_GET['razao_ordem'] : '';
$serie_ordem = isset($_GET['serie_ordem']) ? $_GET['serie_ordem'] : '';
$entregar_ordem = isset($_GET['entregar_ordem']) ? $_GET['entregar_ordem'] : '';

// Iniciando a consulta SQL
$query = "SELECT * FROM ordem_servico WHERE 1=1";  // Inicia com uma condição verdadeira

// Adicionando filtros à consulta dependendo dos parâmetros passados
if ($no_ordem != '') {
    $query .= " AND no_ordem = '$no_ordem'";
}
if ($data_ordem != '') {
    $query .= " AND data_ordem = '$data_ordem'";
}
if ($razao_ordem != '') {
    $query .= " AND razao_ordem LIKE '%$razao_ordem%'";
}
if ($serie_ordem != '') {
    $query .= " AND serie_ordem = '$serie_ordem'";
}
if ($entregar_ordem != '') {
    $query .= " AND entregar_ordem = '$entregar_ordem'";
}

// Executando a consulta
$result = $conn->query($query);

// Verificando se existem resultados
if ($result->num_rows > 0) {
    // Exibindo os resultados
    while ($row = $result->fetch_assoc()) {
        // Exibe todos os campos da linha encontrada
        echo "<div>";
        foreach ($row as $key => $value) {
            echo "<strong>$key:</strong> $value<br>";  // Exibe o nome da coluna e o valor
        }
        echo "</div><br>";
    }
} else {
    echo "Nenhum resultado encontrado.";
}

// Fechando a conexão
$conn->close();
?>
