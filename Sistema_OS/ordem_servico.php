<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ORDEM DE SERVIÇO</title>
    <link rel="stylesheet" href="css/style_O_S.css">
</head>
<body>
    <section class="section_top">
        <div class="incluir">
            <div onclick="abrirPopup()" class="button-container">
                <img src="img/adicionar_icon.png" alt="Adicionar OS" width="60px">
                <p>Adicionar</p>
            </div>
        </div>

        <div class="incluir">
            <div class="button-container">
                <img src="img/alterar_icon.png" alt="Alterar OS" width="60px">
                <p>Alterar</p>
            </div>
        </div>
    </section>
    
    <hr>

    <section class="section_middle">
        <div class="field-container">
            <label for="no_ordem">No.ORDEM</label>
            <input type="number" id="no_ordem" onkeyup="searchFields()">
        </div>
        
        <div class="field-container">
            <label for="data_ordem">DATA DA ORDEM</label>
            <input type="date" id="data_ordem" onkeyup="searchFields()">
        </div>

        <div class="field-container">
            <label for="razao_ordem">LOCALIZAR PELA RAZAO SOCIAL DO CLIENTE</label>
            <input type="text" id="razao_ordem" onkeyup="searchFields()">
        </div>

        <div class="field-container">
            <label for="serie_ordem">NUMERO DE SÉRIE</label>
            <input type="number" id="serie_ordem" onkeyup="searchFields()">
        </div>

        <div class="field-container">
            <label for="entregar_ordem">ENTREGAR NO DIA</label>
            <input type="date" id="entregar_ordem" onkeyup="searchFields()">
        </div>
    </section>

    <section class="section_bottom">
        <div id="search-results"></div>
    </section>

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
                <button type="button" onclick="confirmarCancelamento()">Cancelar</button>
            </form>
        </div>
    </div>

    <script>
        function searchFields() {
            var no_ordem = document.getElementById("no_ordem").value;
            var data_ordem = document.getElementById("data_ordem").value;
            var razao_ordem = document.getElementById("razao_ordem").value;
            var serie_ordem = document.getElementById("serie_ordem").value;
            var entregar_ordem = document.getElementById("entregar_ordem").value;

            var query = "no_ordem=" + no_ordem + "&data_ordem=" + data_ordem + "&razao_ordem=" + razao_ordem + "&serie_ordem=" + serie_ordem + "&entregar_ordem=" + entregar_ordem;

            if (no_ordem.length == 0 && data_ordem.length == 0 && razao_ordem.length == 0 && serie_ordem.length == 0 && entregar_ordem.length == 0) {
                document.getElementById("search-results").innerHTML = "";
                return;
            }

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

    <script>
        function confirmarCancelamento() {
            let confirmar = confirm("Tem certeza que deseja cancelar?");
            if (confirmar) {
                document.getElementById("popup").style.display = "none";
            } else {
                alert("Cancelamento abortado!");
            }
        }

        function abrirPopup() {
            document.getElementById("popup").style.display = "flex";
        }

        function fecharPopup() {
            document.getElementById("popup").style.display = "none";
        }

        function enviarFormulario() {
            let form = document.getElementById("ordemServicoForm");
            let isValid = true;

            let inputs = form.querySelectorAll('input[required], textarea[required]'); 
            inputs.forEach(input => {
                if (input.value.trim() === "") {
                    isValid = false;
                    input.style.borderColor = "red";
                } else {
                    input.style.borderColor = "";
                }
            });

            if (!isValid) {
                alert("Por favor, preencha todos os campos obrigatórios.");
                return;
            }

            let formData = new FormData(form);

            fetch("salvar_ordem.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                fecharPopup();
                form.reset();
            })
            .catch(error => console.error("Erro:", error));
        }
    </script>
</body>
</html>
