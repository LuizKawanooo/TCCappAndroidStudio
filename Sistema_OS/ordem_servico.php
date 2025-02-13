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
    <div class="no_ordem" style="display: flex;">
        <label for="no_ordem" style="font-size: 23px; font-weight: bold; font-family: Arial, Helvetica, sans-serif;">No.ORDEM</label>
        <input type="number" id="no_ordem" name="no_ordem" onkeyup="searchFields()">
    </div>
    
    <div class="data_ordem" style="display: flex; margin-left: 80px;">
        <label for="data_ordem" style="font-size: 23px; font-weight: bold; font-family: Arial, Helvetica, sans-serif;">DATA DA ORDEM</label>
        <input type="date" id="data_ordem" name="data_ordem" onkeyup="searchFields()">
    </div>

    <div class="razao_ordem" style="display: flex; margin-left: 5px;">
        <label for="razao_ordem" style="font-size: 23px; font-weight: bold; position: relative; font-family: Arial, Helvetica, sans-serif;">LOCALIZAR PELA RAZAO SOCIAL DO CLIENTE</label>
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

<section class="section_bottom" style="display: inline-flex;width: 100%; height: 150px; background: #A6CAF0; position: relative; left: 50%; transform: translate(-50%);">
    <div id="search-results" style="overflow-x:auto; width: 100%;">
        <div class="search-result-row">
        <div class="search-result-header">Coluna 1</div>
        <div class="search-result-header">Coluna 2</div>
        <div class="search-result-header">Coluna 3</div>
        <!-- Adicione mais colunas conforme necessário -->
    </div>
    <div class="search-result-row">
        <div class="search-result-cell">Resultado 1A</div>
        <div class="search-result-cell">Resultado 1B</div>
        <div class="search-result-cell">Resultado 1C</div>
        <!-- Adicione mais células conforme necessário -->
    </div>
    <!-- Mais linhas de resultados aqui -->
    </div>
</section>






    






    



    <script>
        function searchFields() {
    // Pegando os valores dos campos
    let noOrdem = document.getElementById('no_ordem').value.trim();
    let dataOrdem = document.getElementById('data_ordem').value.trim();
    let razaoOrdem = document.getElementById('razao_ordem').value.trim();
    let serieOrdem = document.getElementById('serie_ordem').value.trim();
    let entregarOrdem = document.getElementById('entregar_ordem').value.trim();

    // Construindo a consulta SQL baseada nos campos preenchidos
    let query = "SELECT * FROM orders WHERE 1=1";  // A consulta começa com "WHERE 1=1" para facilitar a adição de condições

    // Adicionando condições aos campos que não estão vazios
    if (noOrdem) {
        query += ` AND no_ordem = '${noOrdem}'`;
    }
    if (dataOrdem) {
        query += ` AND data_ordem = '${dataOrdem}'`;
    }
    if (razaoOrdem) {
        query += ` AND razao_ordem LIKE '%${razaoOrdem}%'`;
    }
    if (serieOrdem) {
        query += ` AND serie_ordem = '${serieOrdem}'`;
    }
    if (entregarOrdem) {
        query += ` AND entregar_ordem = '${entregarOrdem}'`;
    }

    // Aqui você faria a requisição para o banco de dados, com o `query` gerado acima.
    // Exemplo com fetch ou AJAX para enviar para um servidor e receber os dados.

    fetch('/path-to-api-endpoint', {
        method: 'POST',
        body: JSON.stringify({ query: query }),
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => response.json())
    .then(data => {
        displayResults(data);
    })
    .catch(error => console.error('Error fetching data:', error));
}

function displayResults(data) {
    let resultsDiv = document.getElementById('search-results');
    resultsDiv.innerHTML = '';  // Limpar os resultados antigos

    // Criar a tabela de resultados
    if (data.length > 0) {
        data.forEach(item => {
            let row = document.createElement('div');
            row.classList.add('search-result-row');
            row.innerHTML = `
                <div class="search-result-cell">${item.no_ordem}</div>
                <div class="search-result-cell">${item.data_ordem}</div>
                <div class="search-result-cell">${item.razao_ordem}</div>
                <div class="search-result-cell">${item.serie_ordem}</div>
                <div class="search-result-cell">${item.entregar_ordem}</div>
            `;
            resultsDiv.appendChild(row);
        });
    } else {
        resultsDiv.innerHTML = '<p>Nenhum resultado encontrado</p>';
    }
}

    </script>



<script>
function searchFields() {
    var no_ordem = document.getElementById("no_ordem").value;
    var data_ordem = document.getElementById("data_ordem").value;
    var razao_ordem = document.getElementById("razao_ordem").value;
    var serie_ordem = document.getElementById("serie_ordem").value;
    var entregar_ordem = document.getElementById("entregar_ordem").value;

    // Monta a URL para a requisição AJAX, passando todos os campos
    var query = "no_ordem=" + no_ordem + "&data_ordem=" + data_ordem + "&razao_ordem=" + razao_ordem + "&serie_ordem=" + serie_ordem + "&entregar_ordem=" + entregar_ordem;

    // Se algum campo estiver vazio, a pesquisa não é realizada
    if (no_ordem.length == 0 && data_ordem.length == 0 && razao_ordem.length == 0 && serie_ordem.length == 0 && entregar_ordem.length == 0) {
        document.getElementById("search-results").innerHTML = "";
        return;
    }

    // Requisição AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "search.php?" + query, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("search-results").innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}
</script>






    

        <section class="section_bottom" style="display: inline-flex;width: 100%; height: 150px; background: #A6CAF0; position: relative; left: 50%; transform: translate(-50%);">
            
        </section>












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
