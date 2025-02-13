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
        sendError('Nenhuma ordem encontrada.');
    }

    // Retornando os resultados como JSON
    echo json_encode($result);

} catch (PDOException $e) {
    sendError('Erro ao conectar ao banco de dados: ' . $e->getMessage());
} catch (Exception $e) {
    sendError('Erro inesperado: ' . $e->getMessage());
}
?>
