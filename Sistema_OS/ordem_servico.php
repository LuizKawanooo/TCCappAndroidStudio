<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ORDEM DE SERVIÇO</title>
    <link rel="stylesheet" href="css/style_O_S.css">
</head>
<body>
    <section class="section_top" style="display: inline-flex;width: 100%; background: #FFFBF0; position: relative; left: 50%; transform: translate(-50%);">
        <div class="incluir">
            <div onclick="abrirPopup()" style="display: inline-block; align-items: center;text-align: center; margin: 15px;"><img src="img/adicionar_icon.png" alt="Adicionar OS" width="60px" style="position: relative; left: 50%; transform: translate(-50%);"><p style="position: relative;">Adicionar</p></div>
            
        </div>

        <div class="incluir">
            <div style="display: inline-block; align-items: center;text-align: center; margin: 15px;"><img src="img/alterar_icon.png" alt="Alterar OS" width="60px" height="60px" style="position: relative; left: 50%; transform: translate(-50%);"><p style="position: relative;">Alterar</p></div>
        </div>

    </section>
    
<hr style="width: 100%; background: rgb(164, 164, 164); height: 10px;" >



    
<section class="section_middle" style="display: inline-flex;width: 100%; height: 150px; background: #A6CAF0; position: relative; left: 50%; transform: translate(-50%);">
    <!-- Formulário de pesquisa -->
    <div class="no_ordem" style="display: flex;">
        <label for="no_ordem" style="font-size: 23px; font-weight: bold; font-family: Arial, Helvetica, sans-serif;">No.ORDEM</label>
        <input type="number" id="no_ordem" name="no_ordem" onkeyup="searchFields()">
    </div>
        
    <div class="data_ordem" style="display: flex; margin-left: 80px;">
        <label for="data_ordem" style="font-size: 23px; font-weight: bold; font-family: Arial, Helvetica, sans-serif;">DATA DA ORDEM</label>
        <input type="date" id="data_ordem" name="data_ordem" onkeyup="searchFields()">
    </div>
    
    <div class="razao_ordem" style="display: flex; margin-left: 5px;">
        <label for="razao_ordem" style="font-size: 23px; font-weight: bold; position: relative; font-family: Arial, Helvetica, sans-serif;">LOCALIZAR PELA RAZÃO SOCIAL DO CLIENTE</label>
        <input type="text" id="razao_ordem" name="razao_ordem" onkeyup="searchFields()">
    </div>
    
    <div class="serie_ordem" style="display: flex; margin-left: 5px;">
        <label for="serie_ordem" style="font-size: 23px; font-weight: bold; position: relative; font-family: Arial, Helvetica, sans-serif;">NUMERO DE SÉRIE</label>
        <input type="number" id="serie_ordem" name="serie_ordem" onkeyup="searchFields()">
    </div>
    
    <div class="entregar_ordem" style="display: flex; margin-left: 30px;">
        <label for="entregar_ordem" style="font-size: 23px; font-weight: bold; position: relative; font-family: Arial, Helvetica, sans-serif;">ENTREGAR NO DIA</label>
        <input type="date" id="entregar_ordem" name="entregar_ordem" onkeyup="searchFields()">
    </div>
</section>

<div id="resultados"></div> <!-- Aqui os resultados serão exibidos -->





    <?php
// Conexão com o banco de dados
$host = 'bd-os-endo.mysql.uhserver.com';
$db = 'bd_os_endo';
$user = 'joseendologic';
$pass = '{[OSluiz2019';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Recuperando os parâmetros de pesquisa
$no_ordem = isset($_GET['no_ordem']) ? $_GET['no_ordem'] : '';
$data_ordem = isset($_GET['data_ordem']) ? $_GET['data_ordem'] : '';
$razao_ordem = isset($_GET['razao_ordem']) ? $_GET['razao_ordem'] : '';
$serie_ordem = isset($_GET['serie_ordem']) ? $_GET['serie_ordem'] : '';
$entregar_ordem = isset($_GET['entregar_ordem']) ? $_GET['entregar_ordem'] : '';

// Consultando a base de dados com os filtros
$query = "SELECT codigo_cliente, aparelho, marca, modelo, serie, data_entrega, valor 
          FROM ordem_servico 
          WHERE 1=1";

if ($no_ordem) {
    $query .= " AND id = '$no_ordem'";
}
if ($data_ordem) {
    $query .= " AND data_registro = '$data_ordem'";
}
if ($razao_ordem) {
    $query .= " AND codigo_cliente LIKE '%$razao_ordem%'";
}
if ($serie_ordem) {
    $query .= " AND serie = '$serie_ordem'";
}
if ($entregar_ordem) {
    $query .= " AND data_entrega = '$entregar_ordem'";
}

$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Exibindo os resultados
    while($row = $result->fetch_assoc()) {
        echo "<div class='resultado'>
                <p><strong>Cliente:</strong> " . $row['codigo_cliente'] . "</p>
                <p><strong>Aparelho:</strong> " . $row['aparelho'] . "</p>
                <p><strong>Marca:</strong> " . $row['marca'] . "</p>
                <p><strong>Modelo:</strong> " . $row['modelo'] . "</p>
                <p><strong>Série:</strong> " . $row['serie'] . "</p>
                <p><strong>Data de Entrega:</strong> " . $row['data_entrega'] . "</p>
                <p><strong>Valor:</strong> " . $row['valor'] . "</p>
              </div>";
    }
} else {
    echo "Nenhuma ordem encontrada.";
}

$conn->close();
?>







    







<!-- Pop-up -->
<div id="popup" class="popup-container">
    <div class="popup-content">
        <h2>Adicionar Ordem de Serviço</h2>
        <form id="ordemServicoForm">
            <label>Código do Cliente:</label>
            <input type="text" name="codigo_cliente" required>

            <label>Aparelho:</label>
            <input type="text" name="aparelho" required>

            <label>Marca:</label>
            <input type="text" name="marca" required>

            <label>Modelo:</label>
            <input type="text" name="modelo" required>

            <label>Número de Série:</label>
            <input type="text" name="serie" required>

            <label>Acessórios:</label>
            <input type="text" name="acessorios" required>

            <label>Condições:</label>
            <textarea name="condicoes" required></textarea>

            <label>Defeito Informado:</label>
            <textarea name="defeito_informado" required></textarea>

            <label>Descrição do Serviço:</label>
            <textarea name="descricao_servico" required></textarea>

            <label>Entrega:</label>
            <input type="date" name="entrega" required>

            <label>Garantia:</label>
            <input type="text" name="garantia" required>

            <label>Valor:</label>
            <input type="number" step="0.01" name="valor" required>

            <label>Condições de Pagamento:</label>
            <input type="text" name="condicoes_pagamento" required>

            <label>Data de Entrega:</label>
            <input type="date" name="data_entrega" required>

            <button type="button" onclick="enviarFormulario()">OK Enviar</button>
            <!-- Botão de Cancelar -->
            <button type="button" onclick="confirmarCancelamento()">Cancelar</button>
        </form>
    </div>
</div>



<script>
function confirmarCancelamento() {
    let confirmar = confirm("Tem certeza que deseja cancelar?");
    if (confirmar) {
        document.getElementById("popup").style.display = "none";
    } else {
        alert("Cancelamento abortado!");
    }
}
</script>
   
    
<script>
function abrirPopup() {
    document.getElementById("popup").style.display = "flex";
}

function fecharPopup() {
    document.getElementById("popup").style.display = "none";
}

function enviarFormulario() {
    let form = document.getElementById("ordemServicoForm");
    let isValid = true;

    // Verificar se todos os campos obrigatórios estão preenchidos
    let inputs = form.querySelectorAll('input[required], textarea[required]'); 
    inputs.forEach(input => {
        if (input.value.trim() === "") {
            isValid = false;
            input.style.borderColor = "red"; // Destacar o campo vazio
        } else {
            input.style.borderColor = ""; // Remover o destaque se o campo estiver preenchido
        }
    });

    // Se algum campo obrigatório não for preenchido, não envia o formulário
    if (!isValid) {
        alert("Por favor, preencha todos os campos obrigatórios.");
        return;
    }

    // Enviar o formulário se todos os campos obrigatórios forem preenchidos
    let formData = new FormData(form);

    fetch("salvar_ordem.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Exibe a mensagem de sucesso ou erro
        fecharPopup(); // Fecha o pop-up
        form.reset(); // Limpa o formulário
    })
    .catch(error => console.error("Erro:", error));
}

    
</script>  

</body>
</html>
