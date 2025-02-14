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
                        codigo_cliente = '$codigo_cliente', 
                        aparelho = '$aparelho', 
                        marca = '$marca', 
                        modelo = '$modelo', 
                        serie = '$serie', 
                        acessorios = '$acessorios', 
                        condicoes = '$condicoes', 
                        defeito_informado = '$defeito_informado', 
                        descricao_servico = '$descricao_servico', 
                        entrega = '$entrega', 
                        garantia = '$garantia', 
                        valor = '$valor', 
                        condicoes_pagamento = '$condicoes_pagamento', 
                        data_entrega = '$data_entrega'
                    WHERE id = $id_ordem";

    if ($conn->query($update_query) === TRUE) {
        echo "Ordem de serviço atualizada com sucesso!";
    } else {
        echo "Erro ao atualizar ordem de serviço: " . $conn->error;
    }



    // Fechando a conexão
    $stmt->close();
    $conn->close();
}
?>
