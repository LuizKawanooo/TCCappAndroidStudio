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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o ID foi enviado
    if (!isset($_POST['orderId']) || empty($_POST['orderId'])) {
        die("Erro: ID da ordem de serviço não foi enviado.");
    }

    // Obtém o ID da ordem de serviço
    $id_ordem = intval($_POST['orderId']); // Garante que seja um número inteiro

    $codigo_cliente = $_POST['codigo_cliente'];
    $aparelho = $_POST['aparelho'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $serie = $_POST['serie'];
    $acessorios = $_POST['acessorios'];
    $condicoes = $_POST['condicoes'];
    $defeito_informado = $_POST['defeito_informado'];
    $descricao_servico = $_POST['descricao_servico'];
    $entrega = $_POST['entrega'];
    $garantia = $_POST['garantia'];
    $valor = $_POST['valor'];
    $condicoes_pagamento = $_POST['condicoes_pagamento'];
    $data_entrega = $_POST['data_entrega'];

    // Atualiza no banco
    $update_query = "UPDATE ordem_servico SET 
                        codigo_cliente = ?, 
                        aparelho = ?, 
                        marca = ?, 
                        modelo = ?, 
                        serie = ?, 
                        acessorios = ?, 
                        condicoes = ?, 
                        defeito_informado = ?, 
                        descricao_servico = ?, 
                        entrega = ?, 
                        garantia = ?, 
                        valor = ?, 
                        condicoes_pagamento = ?, 
                        data_entrega = ?
                    WHERE id = ?";

    // Preparando a query para evitar SQL Injection
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssssssssssssssi", $codigo_cliente, $aparelho, $marca, $modelo, $serie, $acessorios, $condicoes, $defeito_informado, $descricao_servico, $entrega, $garantia, $valor, $condicoes_pagamento, $data_entrega, $id_ordem);

    if ($stmt->execute()) {
        echo "Ordem de serviço atualizada com sucesso!";
    } else {
        echo "Erro ao atualizar ordem de serviço: " . $stmt->error;
    }

    // Fechando a conexão
    $stmt->close();
    $conn->close();
}
?>
