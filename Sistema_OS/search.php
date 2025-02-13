<?php
header('Content-Type: application/json');

// Conexão com o banco de dados
$host = 'bd-os-endo.mysql.uhserver.com';  // Substitua pelo seu host, se necessário
$dbname = 'bd_os_endo';
$username = 'joseendologic';
$password = '{[OSluiz2019}';

$conexao = new mysqli($host, $username, $password, $dbname);

// Verificar se a conexão foi bem-sucedida
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Receber os parâmetros da pesquisa
$noOrdem = isset($_GET['noOrdem']) ? $_GET['noOrdem'] : '';
$dataOrdem = isset($_GET['dataOrdem']) ? $_GET['dataOrdem'] : '';
$razaoOrdem = isset($_GET['razaoOrdem']) ? $_GET['razaoOrdem'] : '';
$serieOrdem = isset($_GET['serieOrdem']) ? $_GET['serieOrdem'] : '';
$entregarOrdem = isset($_GET['entregarOrdem']) ? $_GET['entregarOrdem'] : '';

// Criar a consulta dinâmica
$query = "SELECT * FROM ordem_servico WHERE 1=1";

if ($noOrdem != '') {
    $query .= " AND id = '$noOrdem'";
}
if ($dataOrdem != '') {
    $query .= " AND data_registro = '$dataOrdem'";
}
if ($razaoOrdem != '') {
    $query .= " AND razao_social LIKE '%$razaoOrdem%'";
}
if ($serieOrdem != '') {
    $query .= " AND serie LIKE '%$serieOrdem%'";
}
if ($entregarOrdem != '') {
    $query .= " AND data_entrega = '$entregarOrdem'";
}

// Executar a consulta no banco
$result = $conexao->query($query);

// Verificar se houve resultados
if ($result->num_rows > 0) {
    // Armazenar os resultados em um array
    $ordens = array();
    while ($row = $result->fetch_assoc()) {
        // Adicionar os campos da ordem aos resultados
        $ordens[] = array(
            'codigo_cliente' => $row['codigo_cliente'],
            'aparelho' => $row['aparelho'],
            'marca' => $row['marca'],
            'modelo' => $row['modelo'],
            'serie' => $row['serie'],
            'acessorios' => $row['acessorios'],
            'condicoes' => $row['condicoes'],
            'defeito_informado' => $row['defeito_informado'],
            'descricao_servico' => $row['descricao_servico'],
            'entrega' => $row['entrega'],
            'garantia' => $row['garantia'],
            'valor' => $row['valor']
        );
    }
    
    // Retornar os resultados como JSON
    echo json_encode($ordens);
} else {
    echo json_encode(array('message' => 'Nenhuma ordem encontrada.'));
}

// Fechar a conexão
$conexao->close();
?>
