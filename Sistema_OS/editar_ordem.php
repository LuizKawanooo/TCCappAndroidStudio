<?php
// Configurações do banco de dados
$host = 'bd-os-endo.mysql.uhserver.com';
$dbname = 'bd_os_endo';
$username = 'joseendologic';
$password = '{[OSluiz2019';

function sendError($message) {
    echo json_encode(["error" => $message]);
    exit;
}

try {
    // Conectar ao banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Receber os dados do formulário
    $codigo_cliente = $_POST['codigo_cliente'];
    $aparelho = $_POST['aparelho'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $serie = $_POST['serie'];
    $data_entrega = $_POST['data_entrega'];
    $valor = $_POST['valor'];

    // Atualizando a ordem de serviço
    $query = "UPDATE ordem_servico SET aparelho = :aparelho, marca = :marca, modelo = :modelo, serie = :serie, data_entrega = :data_entrega, valor = :valor WHERE codigo_cliente = :codigo_cliente";

    // Preparando a consulta
    $stmt = $pdo->prepare($query);

    // Bind dos parâmetros
    $stmt->bindParam(':codigo_cliente', $codigo_cliente);
    $stmt->bindParam(':aparelho', $aparelho);
    $stmt->bindParam(':marca', $marca);
    $stmt->bindParam(':modelo', $modelo);
    $stmt->bindParam(':serie', $serie);
    $stmt->bindParam(':data_entrega', $data_entrega);
    $stmt->bindParam(':valor', $valor);

    // Executando a consulta
    if ($stmt->execute()) {
        echo 'Ordem de serviço atualizada com sucesso!';
    } else {
        sendError('Erro ao atualizar a ordem de serviço.');
    }

} catch (PDOException $e) {
    sendError('Erro ao conectar ao banco de dados: ' . $e->getMessage());
} catch (Exception $e) {
    sendError('Erro inesperado: ' . $e->getMessage());
}
?>
