<?php
// Dados de conexão ao banco de dados
$host = 'bd-os-endo.mysql.uhserver.com';
$dbname = 'bd_os_endo';
$username = 'joseendologic';
$password = '{[OSluiz2019}';

// Função para enviar erro como JSON
function sendError($message) {
    echo json_encode(["error" => $message]);
    exit;
}

try {
    // Conectar ao banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Pegando os parâmetros enviados via POST
    $data = json_decode(file_get_contents('php://input'), true);

    // Criando a consulta SQL
    $query = "SELECT codigo_cliente, aparelho, marca, modelo, serie, data_entrega, valor FROM ordem_servico WHERE 1=1";

    // Adicionando condições à consulta com base nos parâmetros
    if (!empty($data['no_ordem'])) {
        $query .= " AND id = :no_ordem";
    }
    if (!empty($data['data_ordem'])) {
        $query .= " AND data_registro = :data_ordem";
    }
    if (!empty($data['razao_ordem'])) {
        $query .= " AND razao_social LIKE :razao_ordem";
    }
    if (!empty($data['serie_ordem'])) {
        $query .= " AND serie LIKE :serie_ordem";
    }
    if (!empty($data['entregar_ordem'])) {
        $query .= " AND data_entrega = :entregar_ordem";
    }

    // Preparando a consulta
    $stmt = $pdo->prepare($query);

    // Bind dos parâmetros
    if (!empty($data['no_ordem'])) {
        $stmt->bindParam(':no_ordem', $data['no_ordem']);
    }
    if (!empty($data['data_ordem'])) {
        $stmt->bindParam(':data_ordem', $data['data_ordem']);
    }
    if (!empty($data['razao_ordem'])) {
        $stmt->bindParam(':razao_ordem', "%{$data['razao_ordem']}%");
    }
    if (!empty($data['serie_ordem'])) {
        $stmt->bindParam(':serie_ordem', "%{$data['serie_ordem']}%");
    }
    if (!empty($data['entregar_ordem'])) {
        $stmt->bindParam(':entregar_ordem', $data['entregar_ordem']);
    }

    // Executando a consulta
    $stmt->execute();

    // Recuperando os resultados
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Verificando se há resultados
    if (empty($result)) {
        echo '<p>Nenhuma ordem encontrada.</p>';
        exit;
    }

    // Exibição dos resultados em uma tabela
    echo '<table border="1">';
    echo '<tr>
            <th>Código Cliente</th>
            <th>Aparelho</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Série</th>
            <th>Data Entrega</th>
            <th>Valor</th>
            <th>Ações</th>
          </tr>';

    foreach ($result as $row) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['codigo_cliente']) . '</td>';
        echo '<td>' . htmlspecialchars($row['aparelho']) . '</td>';
        echo '<td>' . htmlspecialchars($row['marca']) . '</td>';
        echo '<td>' . htmlspecialchars($row['modelo']) . '</td>';
        echo '<td>' . htmlspecialchars($row['serie']) . '</td>';
        echo '<td>' . htmlspecialchars($row['data_entrega']) . '</td>';
        echo '<td>R$ ' . number_format($row['valor'], 2, ',', '.') . '</td>';
        echo '<td>
                <a href="editar_ordem.php?codigo=' . urlencode($row['codigo_cliente']) . '">
                    <button>Editar</button>
                </a>
              </td>';
        echo '</tr>';
    }

    echo '</table>';

} catch (PDOException $e) {
    sendError('Erro ao conectar ao banco de dados: ' . $e->getMessage());
} catch (Exception $e) {
    sendError('Erro inesperado: ' . $e->getMessage());
}
?>
