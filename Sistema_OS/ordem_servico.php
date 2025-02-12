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
            <div style="display: inline-block; align-items: center;text-align: center; margin: 15px;"><img src="img/adicionar_icon.png" alt="Adicionar OS" width="60px" style="position: relative; left: 50%; transform: translate(-50%);"></div>
            <button onclick="abrirPopup()" style="padding: 10px 20px; font-size: 18px;">Adicionar</button>
        </div>

        <div class="incluir">
            <div style="display: inline-block; align-items: center;text-align: center; margin: 15px;"><img src="img/alterar_icon.png" alt="Alterar OS" width="60px" height="60px" style="position: relative; left: 50%; transform: translate(-50%);"><p style="position: relative;">Alterar</p></div>
        </div>

    </section>
    
<hr style="width: 100%; background: rgb(164, 164, 164); height: 10px;" >

    <section class="section_middle" style="display: inline-flex;width: 100%; height: 150px; background: #A6CAF0; position: relative; left: 50%; transform: translate(-50%);">
        <div class="no_ordem" style="display: flex;">
            <label for="no_ordem" style="font-size: 23px; font-weight: bold; font-family: Arial, Helvetica, sans-serif;">No.ORDEM</label>
            <input type="number" id="no_ordem">
        </div>
        
        <div class="data_ordem" style="display: flex; margin-left: 80px;">
            <label for="data_ordem" style="font-size: 23px; font-weight: bold; font-family: Arial, Helvetica, sans-serif;">DATA DA ORDEM</label>
            <input type="date" id="data_ordem">
        </div>

        <div class="razao_ordem" style="display: flex; margin-left: 5px;">
            <label for="razao_ordem" style="font-size: 23px; font-weight: bold; position: relative; font-family: Arial, Helvetica, sans-serif;">LOCALIZAR PELA RAZAO SOCIAL DO CLIENTE</label>
            <input type="text" id="razao_ordem">
        </div>

        <div class="serie_ordem" style="display: flex; margin-left: 5px;">
            <label for="serie_ordem" style="font-size: 23px; font-weight: bold; position: relative; font-family: Arial, Helvetica, sans-serif;">NUMERO DE SÉRIE</label>
            <input type="number" id="serie_ordem">
        </div>

        <div class="entregar_ordem" style="display: flex; margin-left: 30px;">
            <label for="entregar_ordem" style="font-size: 23px; font-weight: bold; position: relative; font-family: Arial, Helvetica, sans-serif;">ENTREGAR NO DIA</label>
            <input type="date" id="entregar_ordem">
        </div>

    </section>


        <section class="section_bottom" style="display: inline-flex;width: 100%; height: 150px; background: #A6CAF0; position: relative; left: 50%; transform: translate(-50%);">
            
        </section>










    <!-- Botão para abrir o pop-up -->


<!-- <!-- Pop-up -->
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
            <input type="text" name="acessorios">

            <label>Condições:</label>
            <textarea name="condicoes"></textarea>

            <label>Defeito Informado:</label>
            <textarea name="defeito_informado"></textarea>

            <label>Descrição do Serviço:</label>
            <textarea name="descricao_servico"></textarea>

            <label>Entrega:</label>
            <input type="date" name="entrega">

            <label>Garantia:</label>
            <input type="text" name="garantia">

            <label>Valor:</label>
            <input type="number" step="0.01" name="valor" required>

            <label>Condições de Pagamento:</label>
            <input type="text" name="condicoes_pagamento">

            <label>Data de Entrega:</label>
            <input type="date" name="data_entrega">

            <button type="button" onclick="enviarFormulario()">OK Enviar</button>
            <button type="button" onclick="fecharPopup()">Cancelar</button>
        </form>
    </div>
</div> -->



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
            <input type="text" name="acessorios" required> <!-- Tornado obrigatório -->

            <label>Condições:</label>
            <textarea name="condicoes" required></textarea> <!-- Tornado obrigatório -->

            <label>Defeito Informado:</label>
            <textarea name="defeito_informado" required></textarea> <!-- Tornado obrigatório -->

            <label>Descrição do Serviço:</label>
            <textarea name="descricao_servico" required></textarea> <!-- Tornado obrigatório -->

            <label>Entrega:</label>
            <input type="date" name="entrega" required> <!-- Tornado obrigatório -->

            <label>Garantia:</label>
            <input type="text" name="garantia" required> <!-- Tornado obrigatório -->

            <label>Valor:</label>
            <input type="number" step="0.01" name="valor" required>

            <label>Condições de Pagamento:</label>
            <input type="text" name="condicoes_pagamento" required> <!-- Tornado obrigatório -->

            <label>Data de Entrega:</label>
            <input type="date" name="data_entrega" required> <!-- Tornado obrigatório -->

            <button type="button" onclick="enviarFormulario()">OK Enviar</button>
            <button type="button" onclick="fecharPopup()">Cancelar</button>
        </form>
    </div>
</div>






    <script>
function abrirPopup() {
    document.getElementById("popup").style.display = "flex";
}

function fecharPopup() {
    document.getElementById("popup").style.display = "none";
}

function enviarFormulario() {
    let form = document.getElementById("ordemServicoForm");
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
