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
    <form id="searchForm" method="GET">
        <div class="form-group">
            <label for="no_ordem">No. ORDEM</label>
            <input type="number" id="no_ordem" name="no_ordem" onkeyup="searchFields()">
        </div>
        
        <div class="form-group">
            <label for="data_ordem">DATA DA ORDEM</label>
            <input type="date" id="data_ordem" name="data_ordem" onkeyup="searchFields()">
        </div>

        <div class="form-group">
            <label for="razao_ordem">LOCALIZAR PELA RAZÃO SOCIAL DO CLIENTE</label>
            <input type="text" id="razao_ordem" name="razao_ordem" onkeyup="searchFields()">
        </div>

        <div class="form-group">
            <label for="serie_ordem">NUMERO DE SÉRIE</label>
            <input type="number" id="serie_ordem" name="serie_ordem" onkeyup="searchFields()">
        </div>

        <div class="form-group">
            <label for="entregar_ordem">ENTREGAR NO DIA</label>
            <input type="date" id="entregar_ordem" name="entregar_ordem" onkeyup="searchFields()">
        </div>
    </form>

    
</section>

<section class="section_bottom" style="display: inline-flex;width: 100%; height: 150px; background: #A6CAF0; position: relative; left: 50%; transform: translate(-50%);">
<table border="1" id="resultTable">
        <thead>
            <tr>
                <th>No. Ordem</th>
                <th>Data da Ordem</th>
                <th>Razão Social</th>
                <th>Número de Série</th>
                <th>Entregar no Dia</th>
            </tr>
        </thead>
        <tbody>
            <!-- Os resultados da pesquisa serão exibidos aqui -->
        </tbody>
    </table>
</section>





    <script>
        // Função que será chamada ao digitar nos campos
        function searchFields() {
            // Obtendo os valores dos campos de pesquisa
            let no_ordem = document.getElementById('no_ordem').value;
            let data_ordem = document.getElementById('data_ordem').value;
            let razao_ordem = document.getElementById('razao_ordem').value;
            let serie_ordem = document.getElementById('serie_ordem').value;
            let entregar_ordem = document.getElementById('entregar_ordem').value;

            // Criando a URL com os parâmetros de pesquisa
            let url = 'search.php?';
            if (no_ordem) url += `no_ordem=${no_ordem}&`;
            if (data_ordem) url += `data_ordem=${data_ordem}&`;
            if (razao_ordem) url += `razao_ordem=${razao_ordem}&`;
            if (serie_ordem) url += `serie_ordem=${serie_ordem}&`;
            if (entregar_ordem) url += `entregar_ordem=${entregar_ordem}&`;

            // Removendo o último "&" caso tenha
            url = url.slice(0, -1);

            // Realizando a chamada AJAX para buscar os dados
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // Limpar a tabela antes de adicionar os resultados
                    let tbody = document.getElementById('resultTable').getElementsByTagName('tbody')[0];
                    tbody.innerHTML = '';

                    // Adicionando os resultados na tabela
                    data.forEach(row => {
                        let tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${row.no_ordem}</td>
                            <td>${row.data_ordem}</td>
                            <td>${row.razao_ordem}</td>
                            <td>${row.serie_ordem}</td>
                            <td>${row.entregar_ordem}</td>
                        `;
                        tbody.appendChild(tr);
                    });
                })
                .catch(error => console.error('Erro:', error));
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
