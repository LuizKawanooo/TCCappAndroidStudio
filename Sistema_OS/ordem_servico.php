<?php
// Verifica se o parâmetro 'serie_ordem' não está presente na URL
if (!isset($_GET['serie_ordem'])) {
    // Redireciona para a URL com o parâmetro 'serie_ordem=-'
    header("Location: ordem_servico.php?serie_ordem=-");
    exit(); // Garante que o script pare a execução após o redirecionamento
}



// Variável para armazenar a mensagem
$mensagem_alerta = "";

// Se a URL contiver exatamente 'serie_ordem=-', define a mensagem
if (isset($_GET['serie_ordem']) && $_GET['serie_ordem'] === '-') {
    $mensagem_alerta = "<h1>POR FAVOR, PREENCHA ALGUM CAMPO PARA REALIZAR A PESQUISA...</h1>";
}

    
?>

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
    

<div id="alertasearch"><?php echo $mensagem_alerta; ?></div>

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
    if ($data_ordem != '') {
        // Converter de 'DD/MM/YYYY' para 'YYYY-MM-DD' (se necessário)
        $data_ordem_formatada = date('Y-m-d', strtotime(str_replace('/', '-', $data_ordem)));
        $conditions[] = "data_registro = '$data_ordem_formatada'";
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
<div id="popupModal" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); justify-content: center; align-items: center; z-index: 1000;">
    <div style="max-height: 650px; overflow-y: auto;background: rgb(233, 233, 233); padding: 20px; border-radius: 8px; width: 400px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); position: relative; left: 50%; top: 50%; transform: translate(-50%, -50%);">
        <h3 style="text-align: center; font-size: 16px; margin-bottom: 8px; background: #d9d9d9; padding: 6px; border-bottom: 2px solid #ccc;">Editar Ordem de Serviço</h3>

        <form id="editForm" method="POST" action="atualizar_ordem.php">
            <input type="hidden" id="orderId" name="orderId">

            <label for="codigo_cliente" style="display: block; font-weight: bold; margin-top: 6px; font-size: 12px;">Código Cliente:</label>
            <input type="text" id="codigo_cliente" name="codigo_cliente" required style="width: calc(100% - 10px); height: 13px; margin: 3px 0; padding: 5px; border: 1px solid #888; border-radius: 3px; background: white; font-size: 12px;"><br><br>

            <label for="aparelho" style="display: block; font-weight: bold; margin-top: 6px; font-size: 12px;">Aparelho:</label>
            <input type="text" id="aparelho" name="aparelho" required style="width: calc(100% - 10px); height: 13px; margin: 3px 0; padding: 5px; border: 1px solid #888; border-radius: 3px; background: white; font-size: 12px;"><br><br>

            <label for="marca" style="display: block; font-weight: bold; margin-top: 6px; font-size: 12px;">Marca:</label>
            <input type="text" id="marca" name="marca" required style="width: calc(100% - 10px); height: 13px; margin: 3px 0; padding: 5px; border: 1px solid #888; border-radius: 3px; background: white; font-size: 12px;"><br><br>

            <label for="modelo" style="display: block; font-weight: bold; margin-top: 6px; font-size: 12px;">Modelo:</label>
            <input type="text" id="modelo" name="modelo" required style="width: calc(100% - 10px); height: 13px; margin: 3px 0; padding: 5px; border: 1px solid #888; border-radius: 3px; background: white; font-size: 12px;"><br><br>

            <label for="serie" style="display: block; font-weight: bold; margin-top: 6px; font-size: 12px;">Série:</label>
            <input type="text" id="serie" name="serie" required style="width: calc(100% - 10px); height: 13px; margin: 3px 0; padding: 5px; border: 1px solid #888; border-radius: 3px; background: white; font-size: 12px;"><br><br>

            <label for="acessorios" style="display: block; font-weight: bold; margin-top: 6px; font-size: 12px;">Acessórios:</label>
            <input type="text" id="acessorios" name="acessorios" style="width: calc(100% - 10px); height: 13px; margin: 3px 0; padding: 5px; border: 1px solid #888; border-radius: 3px; background: white; font-size: 12px;"><br><br>

            <label for="condicoes" style="display: block; font-weight: bold; margin-top: 6px; font-size: 12px;">Condições:</label>
            <input type="text" id="condicoes" name="condicoes" style="width: calc(100% - 10px); height: 13px; margin: 3px 0; padding: 5px; border: 1px solid #888; border-radius: 3px; background: white; font-size: 12px;"><br><br>

            <label for="defeito_informado" style="display: block; font-weight: bold; margin-top: 6px; font-size: 12px;">Defeito Informado:</label>
            <input type="text" id="defeito_informado" name="defeito_informado" style="width: calc(100% - 10px); height: 13px; margin: 3px 0; padding: 5px; border: 1px solid #888; border-radius: 3px; background: white; font-size: 12px;"><br><br>

            <label for="descricao_servico" style="display: block; font-weight: bold; margin-top: 6px; font-size: 12px;">Descrição do Serviço:</label>
            <textarea id="descricao_servico" name="descricao_servico" style="width: calc(100% - 10px); height: 40px; margin: 3px 0; padding: 5px; border: 1px solid #888; border-radius: 3px; background: white; font-size: 12px;"></textarea><br><br>

            <label for="entrega" style="display: block; font-weight: bold; margin-top: 6px; font-size: 12px;">Entrega:</label>
            <input type="text" id="entrega" name="entrega" style="width: calc(100% - 10px); height: 13px; margin: 3px 0; padding: 5px; border: 1px solid #888; border-radius: 3px; background: white; font-size: 12px;"><br><br>

            <label for="garantia" style="display: block; font-weight: bold; margin-top: 6px; font-size: 12px;">Garantia:</label>
            <input type="text" id="garantia" name="garantia" style="width: calc(100% - 10px); height: 13px; margin: 3px 0; padding: 5px; border: 1px solid #888; border-radius: 3px; background: white; font-size: 12px;"><br><br>

            <label for="valor" style="display: block; font-weight: bold; margin-top: 6px; font-size: 12px;">Valor:</label>
            <input type="text" id="valor" name="valor" required style="width: calc(100% - 10px); height: 13px; margin: 3px 0; padding: 5px; border: 1px solid #888; border-radius: 3px; background: white; font-size: 12px;"><br><br>

            <label for="condicoes_pagamento" style="display: block; font-weight: bold; margin-top: 6px; font-size: 12px;">Condições de Pagamento:</label>
            <input type="text" id="condicoes_pagamento" name="condicoes_pagamento" style="width: calc(100% - 10px); height: 13px; margin: 3px 0; padding: 5px; border: 1px solid #888; border-radius: 3px; background: white; font-size: 12px;"><br><br>

            <label for="data_entrega" style="display: block; font-weight: bold; margin-top: 6px; font-size: 12px;">Data de Entrega:</label>
            <input type="date" id="data_entrega" name="data_entrega" required style="width: calc(100% - 10px); height: 13px; margin: 3px 0; padding: 5px; border: 1px solid #888; border-radius: 3px; background: white; font-size: 12px;"><br><br>

            <button type="submit" style="padding: 8px 12px; background: green; color: white; border: none; border-radius: 3px; font-size: 12px; cursor: pointer; transition: 0.3s;">Salvar Alterações</button>
        </form>

        <button onclick="closePopup()" style="padding: 8px 12px; margin-top: 12px; background: red; color: white; border: none; border-radius: 3px; font-size: 12px; cursor: pointer; transition: 0.3s;">Fechar</button>
    </div>
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
            // Preencher os campos do formulário com os dados da ordem de serviço
            document.getElementById('orderId').value = data.id;
            document.getElementById('codigo_cliente').value = data.codigo_cliente;
            document.getElementById('aparelho').value = data.aparelho;
            document.getElementById('marca').value = data.marca;
            document.getElementById('modelo').value = data.modelo;
            document.getElementById('serie').value = data.serie;
            document.getElementById('acessorios').value = data.acessorios;
            document.getElementById('condicoes').value = data.condicoes;
            document.getElementById('defeito_informado').value = data.defeito_informado;
            document.getElementById('descricao_servico').value = data.descricao_servico;
            document.getElementById('entrega').value = data.entrega;
            document.getElementById('garantia').value = data.garantia;
            document.getElementById('valor').value = data.valor;
            document.getElementById('condicoes_pagamento').value = data.condicoes_pagamento;
            document.getElementById('data_entrega').value = data.data_entrega;


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
    document.getElementById("popup").style.display = "block"; // Open the popup
}

function fecharPopup() {
    document.getElementById("popup").style.display = "none"; // Close the popup
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
