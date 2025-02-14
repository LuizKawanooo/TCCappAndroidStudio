<?php
// Conexão com o banco
$servername = "bd-os-endo.mysql.uhserver.com";
$username = "joseendologic";
$password = "{[OSluiz2019";
$dbname = "bd_os_endo";

// Estabelecendo a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificando se os dados do formulário foram enviados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebendo os dados do formulário
    $orderId = $_POST['orderId'];
    $codigo_cliente = $_POST['codigo_cliente'];
    $aparelho = $_POST['aparelho'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $serie = $_POST['serie'];
    $data_entrega = $_POST['data_entrega'];
    $valor = $_POST['valor'];

    // Validando os dados (opcional, dependendo da sua aplicação)
    if (empty($codigo_cliente) || empty($aparelho) || empty($marca) || empty($modelo) || empty($serie) || empty($data_entrega) || empty($valor)) {
        echo "Todos os campos são obrigatórios!";
        exit;
    }

    // Preparando a consulta para atualizar os dados no banco
    $query = "UPDATE ordem_servico SET
                codigo_cliente = ?, aparelho = ?, marca = ?, modelo = ?, serie = ?, data_entrega = ?, valor = ?
                WHERE id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssdi", $codigo_cliente, $aparelho, $marca, $modelo, $serie, $data_entrega, $valor, $orderId);

    // Executando a consulta
    if ($stmt->execute()) {
        // Redireciona para a página da tabela ou exibe uma mensagem de sucesso
        echo "Ordem de serviço atualizada com sucesso!";
    } else {
        echo "Erro ao atualizar a ordem de serviço: " . $stmt->error;
    }

    // Fechando a conexão
    $stmt->close();
    $conn->close();
}
?>
