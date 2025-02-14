<?php
// Conexão com o banco
$host = 'bd-os-endo.mysql.uhserver.com';
$dbname = 'bd_os_endo';
$username = 'joseendologic';
$password = '{[OSluiz2019';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco: " . $e->getMessage());
}

// Buscar ordens de serviço
$stmt = $pdo->query("SELECT codigo_cliente, aparelho, marca, modelo, serie, data_entrega, valor FROM ordem_servico");
$ordens = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

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

    <script>
        function abrirPopup() {
    document.getElementById("popupadd").style.display = "flex";
}

    </script>


    
<hr style="width: 100%; background: rgb(164, 164, 164); height: 10px;" >



    
<section class="section_middle" style="display: inline-flex; width: 100%; height: 150px; background: #A6CAF0; position: relative; left: 50%; transform: translate(-50%);">
    <!-- Formulário de pesquisa -->
    <div class="no_ordem" style="display: flex;">
        <label for="no_ordem" style="font-size: 23px; font-weight: bold; font-family: Arial, Helvetica, sans-serif;">No.ORDEM</label>
        <input type="number" id="no_ordem" name="no_ordem">
    </div>

    <div class="data_ordem" style="display: flex; margin-left: 80px;">
        <label for="data_ordem" style="font-size: 23px; font-weight: bold; font-family: Arial, Helvetica, sans-serif;">DATA DA ORDEM</label>
        <input type="date" id="data_ordem" name="data_ordem">
    </div>
    
    <div class="serie_ordem" style="display: flex; margin-left: 5px;">
        <label for="serie_ordem" style="font-size: 23px; font-weight: bold; position: relative; font-family: Arial, Helvetica, sans-serif;">NUMERO DE SÉRIE</label>
        <input type="text" id="serie_ordem" name="serie_ordem">
    </div>
    

    <div class="razao_ordem" style="display: flex; margin-left: 5px;">
        <label for="razao_ordem" style="font-size: 23px; font-weight: bold; position: relative; font-family: Arial, Helvetica, sans-serif;">LOCALIZAR PELA RAZÃO SOCIAL DO CLIENTE</label>
        <input type="text" id="razao_ordem" name="razao_ordem">
    </div>

    
    
    <div class="entregar_ordem" style="display: flex; margin-left: 30px;">
        <label for="entregar_ordem" style="font-size: 23px; font-weight: bold; position: relative; font-family: Arial, Helvetica, sans-serif;">ENTREGAR NO DIA</label>
        <input type="date" id="entregar_ordem" name="entregar_ordem">
    </div>

    <!-- Botão de Envio -->
    <div style="display: flex; align-items: center; margin-left: 70px; margin-top: 20px;">
        <button onclick="searchFields()" style="font-size: 18px; font-weight: bold; background-color: #4CAF50; color: white; padding: 10px 20px; border: none; cursor: pointer;">Pesquisar</button>
    </div>
</section>



<!-- Exibição dos resultados -->
<div id="resultados"></div>

<script>
function searchFields() {
    // Pegando os valores dos campos de entrada
    var no_ordem = document.getElementById('no_ordem').value;
    var data_ordem = document.getElementById('data_ordem').value;
    var serie_ordem = document.getElementById('serie_ordem').value;
    var entregar_ordem = document.getElementById('entregar_ordem').value;

    // Construir a URL de pesquisa com os parâmetros preenchidos
    var query = '?';

    if (no_ordem) {
        query += 'no_ordem=' + no_ordem + '&';
    }
    if (data_ordem) {
        query += 'data_ordem=' + data_ordem + '&';
    }
    if (serie_ordem) {
        query += 'serie_ordem=' + serie_ordem + '&';
    }
    if (entregar_ordem) {
        query += 'entregar_ordem=' + entregar_ordem + '&';
    }

    // Remover o último caractere '&' (se houver)
    query = query.slice(0, -1);

    // Enviar a pesquisa para o servidor (ajustar o URL conforme necessário)
    window.location.href = 'ordem_servico.php' + query;
}

</script>



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

// Pegar os parâmetros da pesquisa
$no_ordem = isset($_GET['no_ordem']) ? $_GET['no_ordem'] : '';
$data_ordem = isset($_GET['data_ordem']) ? $_GET['data_ordem'] : '';
$serie_ordem = isset($_GET['serie_ordem']) ? $_GET['serie_ordem'] : '';
$entregar_ordem = isset($_GET['entregar_ordem']) ? $_GET['entregar_ordem'] : '';

// Iniciar a query com "WHERE 1=1" para facilitar a construção das condições
$query = "SELECT * FROM ordem_servico WHERE 1=1";

// Criar um array de condições para concatenar com a query
$conditions = [];

// Adicionar as condições conforme os campos preenchidos
if ($no_ordem != '') {
    $conditions[] = "id = '$no_ordem'";
}
if ($data_ordem != '') {
    $conditions[] = "data_registro = '$data_ordem'";
}
if ($serie_ordem != '') {
    $conditions[] = "serie = '$serie_ordem'";
}
if ($entregar_ordem != '') {
    $conditions[] = "data_entrega = '$entregar_ordem'";
}

// Concatenar as condições na query se existirem
if (count($conditions) > 0) {
    $query .= " AND " . implode(" AND ", $conditions);
} else {
    echo "Por favor, preencha algum campo para realizar a pesquisa.";
    exit();
}

// Executar a consulta
$result = $conn->query($query);


// Checar se há resultados
if ($result->num_rows > 0) {
    echo '<div style="overflow-x: auto;">';
    echo '<table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; text-align: left;">';
    
    // Cabeçalho da tabela
    echo '<tr style="background: yellow; border: 2px solid black;">';
    echo '<th style="padding: 10px; border: 2px solid black;">Código Cliente</th>';
    echo '<th style="padding: 10px; border: 2px solid black;">Aparelho</th>';
    echo '<th style="padding: 10px; border: 2px solid black;">Marca</th>';
    echo '<th style="padding: 10px; border: 2px solid black;">Modelo</th>';
    echo '<th style="padding: 10px; border: 2px solid black;">Série</th>';
    echo '<th style="padding: 10px; border: 2px solid black;">Acessórios</th>';
    echo '<th style="padding: 10px; border: 2px solid black;">Condições</th>';
    echo '<th style="padding: 10px; border: 2px solid black;">Defeito Informado</th>';
    echo '<th style="padding: 10px; border: 2px solid black;">Descrição Serviço</th>';
    echo '<th style="padding: 10px; border: 2px solid black;">Entrega</th>';
    echo '<th style="padding: 10px; border: 2px solid black;">Garantia</th>';
    echo '<th style="padding: 10px; border: 2px solid black;">Valor</th>';
    echo '<th style="padding: 10px; border: 2px solid black;">Condições Pagamento</th>';
    echo '<th style="padding: 10px; border: 2px solid black;">Data Entrega</th>';
    echo '<th style="padding: 10px; border: 2px solid black;">Data Registro</th>';
    echo '<th style="padding: 10px; border: 2px solid black;">Ações</th>';
    echo '</tr>';

    $row_count = 0; // Contador para alternar as cores das linhas

    while ($row = $result->fetch_assoc()) {
        $background_color = ($row_count % 2 == 0) ? "#f0f0f0" : "#ffffff"; // Cinza claro e branco alternados

        echo '<tr style="background: ' . $background_color . '; border: 2px solid black;">';
        echo '<td style="padding: 10px; border: 2px solid black;">' . $row["codigo_cliente"] . '</td>';
        echo '<td style="padding: 10px; border: 2px solid black;">' . $row["aparelho"] . '</td>';
        echo '<td style="padding: 10px; border: 2px solid black;">' . $row["marca"] . '</td>';
        echo '<td style="padding: 10px; border: 2px solid black;">' . $row["modelo"] . '</td>';
        echo '<td style="padding: 10px; border: 2px solid black;">' . $row["serie"] . '</td>';
        echo '<td style="padding: 10px; border: 2px solid black;">' . $row["acessorios"] . '</td>';
        echo '<td style="padding: 10px; border: 2px solid black;">' . $row["condicoes"] . '</td>';
        echo '<td style="padding: 10px; border: 2px solid black;">' . $row["defeito_informado"] . '</td>';
        echo '<td style="padding: 10px; border: 2px solid black;">' . $row["descricao_servico"] . '</td>';
        echo '<td style="padding: 10px; border: 2px solid black;">' . $row["entrega"] . '</td>';
        echo '<td style="padding: 10px; border: 2px solid black;">' . $row["garantia"] . '</td>';
        echo '<td style="padding: 10px; border: 2px solid black;">R$ ' . number_format($row["valor"], 2, ',', '.') . '</td>';
        echo '<td style="padding: 10px; border: 2px solid black;">' . $row["condicoes_pagamento"] . '</td>';
        echo '<td style="padding: 10px; border: 2px solid black;">' . date("d/m/Y", strtotime($row["data_entrega"])) . '</td>';
        echo '<td style="padding: 10px; border: 2px solid black;">' . date("d/m/Y", strtotime($row["data_registro"])) . '</td>';
        echo '<td style="padding: 10px; border: 2px solid black; text-align: center;">
            <a href="javascript:void(0);" onclick="openPopup(' . $row['id'] . ')" class="editar-btn" style="text-decoration: none; background: blue; color: white; padding: 5px 10px; border-radius: 5px;">Editar</a>
          </td>';
        echo '</tr>';
        $row_count++;
    }

    echo '</table>';
    echo '</div>';
} else {
    echo "Nenhum resultado encontrado.";
}


$conn->close();
?>







<!-- Popup Modal -->
<div id="popupModal" style="display:none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border: 2px solid black; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2); z-index: 1000;">
    <h3>Editar Ordem de Serviço</h3>
    <form id="editForm" method="POST" action="atualizar_ordem.php">
        <input type="hidden" id="orderId" name="orderId">
        <label for="codigo_cliente">Código Cliente:</label>
        <input type="text" id="codigo_cliente" name="codigo_cliente" required><br><br>

        <label for="aparelho">Aparelho:</label>
        <input type="text" id="aparelho" name="aparelho" required><br><br>

        <label for="marca">Marca:</label>
        <input type="text" id="marca" name="marca" required><br><br>

        <label for="modelo">Modelo:</label>
        <input type="text" id="modelo" name="modelo" required><br><br>

        <label for="serie">Série:</label>
        <input type="text" id="serie" name="serie" required><br><br>

        <label for="data_entrega">Data de Entrega:</label>
        <input type="date" id="data_entrega" name="data_entrega" required><br><br>

        <label for="valor">Valor:</label>
        <input type="text" id="valor" name="valor" required><br><br>

        <button type="submit" style="background: green; color: white;">Salvar Alterações</button>
    </form>
    <button onclick="closePopup()">Fechar</button>
</div>

<!-- Background Overlay -->
<div id="overlay" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 999;"></div>

<script>
    function openPopup(id) {
        // Buscar os dados da ordem de serviço usando o ID
        fetch('get_ordem.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                // Preencher os campos do formulário com os dados da ordem de serviço
                document.getElementById('orderId').value = data.id;
                document.getElementById('codigo_cliente').value = data.codigo_cliente;
                document.getElementById('aparelho').value = data.aparelho;
                document.getElementById('marca').value = data.marca;
                document.getElementById('modelo').value = data.modelo;
                document.getElementById('serie').value = data.serie;
                document.getElementById('data_entrega').value = data.data_entrega;
                document.getElementById('valor').value = data.valor;

                // Exibir o popup
                document.getElementById('popupModal').style.display = 'block';
                document.getElementById('overlay').style.display = 'block';
            });
    }

    function closePopup() {
        // Fechar o popup e o fundo
        document.getElementById('popupModal').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
    }
</script>





    







<!-- Botão para abrir o popup -->
<button type="button" onclick="abrirPopup()">Adicionar Ordem de Serviço</button>

<!-- Pop-up -->
<div id="popupadd" class="popup-container" style="display: none;">
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
// Função para abrir o popup
function abrirPopup() {
    document.getElementById("popupadd").style.display = "block"; // Abre o popup
}

// Função para fechar o popup
function fecharPopup() {
    document.getElementById("popupadd").style.display = "none"; // Fecha o popup
}

// Função para confirmar o cancelamento
function confirmarCancelamento() {
    let confirmar = confirm("Tem certeza que deseja cancelar?");
    if (confirmar) {
        fecharPopup(); // Fecha o popup
    } else {
        alert("Cancelamento abortado!");
    }
}

// Função para enviar o formulário
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
