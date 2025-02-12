<?php
$servername = "bd-os-endo.mysql.uhserver.com"; 
$username = "joseendologic"; 
$password = "{[OSluiz2019"; 
$database = "bd_os_endo";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coletando dados do formulário
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

    // Verificando se todos os campos obrigatórios foram preenchidos
    if (empty($codigo_cliente) || empty($aparelho) || empty($marca) || empty($modelo) || empty($serie) || empty($valor)) {
        echo "Por favor, preencha todos os campos obrigatórios!";
    } else {
        // Inserindo dados no banco de dados
        $sql = "INSERT INTO ordem_servico (codigo_cliente, aparelho, marca, modelo, serie, acessorios, condicoes, defeito_informado, descricao_servico, entrega, garantia, valor, condicoes_pagamento, data_entrega)
                VALUES ('$codigo_cliente', '$aparelho', '$marca', '$modelo', '$serie', '$acessorios', '$condicoes', '$defeito_informado', '$descricao_servico', '$entrega', '$garantia', '$valor', '$condicoes_pagamento', '$data_entrega')";

        if ($conn->query($sql) === TRUE) {
            echo "Ordem de serviço cadastrada com sucesso!";
        } else {
            echo "Erro: " . $conn->error;
        }
    }
}

$conn->close();
?>

