<?php
$servername = "bd-os-endo.mysql.uhserver.com";
$username = "joseendologic";
$password = "{[OSluiz2019";
$dbname = "bd_os_endo";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Checar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se o ID da ordem foi passado na URL
if (isset($_GET['id'])) {
    $id_ordem = $_GET['id'];

    // Buscar os dados da ordem de serviço para editar
    $query = "SELECT id, codigo_cliente, aparelho, marca, modelo, serie, acessorios, condicoes, 
          defeito_informado, descricao_servico, entrega, garantia, valor, 
          condicoes_pagamento, data_entrega, data_registro 
          FROM ordem_servico WHERE id = $id_ordem";

    $result = $conn->query($query);

    // Se a ordem for encontrada, preencher o formulário de edição
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Ordem de serviço não encontrada.";
        exit();
    }
} else {
    echo "ID da ordem não fornecido.";
    exit();
}

// Verificar se o formulário foi enviado para atualizar os dados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo_cliente = $_POST['codigo_cliente'];
    $aparelho = $_POST['aparelho'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $serie = $_POST['serie'];
    $data_entrega = $_POST['data_entrega'];
    $valor = $_POST['valor'];

    // Atualizar os dados no banco de dados
    $update_query = "UPDATE ordem_servico SET codigo_cliente = '$codigo_cliente', aparelho = '$aparelho', marca = '$marca', modelo = '$modelo', serie = '$serie', data_entrega = '$data_entrega', valor = '$valor' WHERE id = $id_ordem";

    if ($conn->query($update_query) === TRUE) {
        echo "Ordem de serviço atualizada com sucesso!";
    } else {
        echo "Erro ao atualizar ordem de serviço: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Ordem de Serviço</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .form-container input[type="text"],
        .form-container input[type="number"],
        .form-container input[type="date"],
        .form-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        .form-container input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<!-- Botão para abrir o popup -->
<button id="editBtn" style="background-color: blue; color: white; padding: 10px; border-radius: 5px; cursor: pointer;">Editar Ordem</button>

<!-- O Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Editar Ordem de Serviço</h2>
        <form method="POST" action="">
            <input type="text" name="codigo_cliente" value="<?php echo htmlspecialchars($row['codigo_cliente']); ?>" placeholder="Código Cliente" required>
            <input type="text" name="aparelho" value="<?php echo htmlspecialchars($row['aparelho']); ?>" placeholder="Aparelho" required>
            <input type="text" name="marca" value="<?php echo htmlspecialchars($row['marca']); ?>" placeholder="Marca" required>
            <input type="text" name="modelo" value="<?php echo htmlspecialchars($row['modelo']); ?>" placeholder="Modelo" required>
            <input type="text" name="serie" value="<?php echo htmlspecialchars($row['serie']); ?>" placeholder="Série" required>
            <input type="date" name="data_entrega" value="<?php echo htmlspecialchars($row['data_entrega']); ?>" placeholder="Data de Entrega" required>
            <input type="number" step="0.01" name="valor" value="<?php echo htmlspecialchars($row['valor']); ?>" placeholder="Valor" required>
            <input type="submit" value="Atualizar Ordem de Serviço">
        </form>
    </div>
</div>

<script>
// Obter o modal
var modal = document.getElementById("editModal");

// Obter o botão que abre o modal
var btn = document.getElementById("editBtn");

// Obter o <span> que fecha o modal
var span = document.getElementsByClassName("close")[0];

// Quando o usuário clicar no botão, abre o modal
btn.onclick = function() {
    modal.style.display = "block";
}

// Quando o usuário clicar no <span> (x), fecha o modal
span.onclick = function() {
    modal.style.display = "none";
}

// Quando o usuário clicar em qualquer lugar fora do modal, fecha-o
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

</body>
</html>
