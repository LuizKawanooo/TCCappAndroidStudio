<?php
// Conexão com o banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pesquisa de Músicas</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Pesquise e Adicione Músicas à Fila</h1>
    <form id="searchForm">
        <input type="text" id="searchQuery" placeholder="Digite o nome da música" required>
        <button type="submit">Pesquisar</button>
    </form>
    <div id="searchResults"></div>
    <h2>Fila de Reprodução</h2>
    <ul id="queueList"></ul>
    <button id="playQueue">Reproduzir Fila</button>

    <script>
        $(document).ready(function() {
            // Função para pesquisar músicas
            $('#searchForm').submit(function(e) {
                e.preventDefault();
                var query = $('#searchQuery').val();
                $.ajax({
                    url: 'https://www.googleapis.com/youtube/v3/search',
                    method: 'GET',
                    data: {
                        part: 'snippet',
                        q: query,
                        type: 'video',
                        key: 'SUA_CHAVE_DE_API_DO_YOUTUBE'
                    },
                    success: function(data) {
                        $('#searchResults').empty();
                        data.items.forEach(function(item) {
                            var videoId = item.id.videoId;
                            var title = item.snippet.title;
                            $('#searchResults').append(`
                                <div>
                                    <p>${title}</p>
                                    <button onclick="addToQueue('${videoId}', '${title}')">Adicionar à Fila</button>
                                </div>
                            `);
                        });
                    }
                });
            });

            // Função para adicionar música à fila
            window.addToQueue = function(videoId, title) {
                $.post('add_to_queue.php', { videoId: videoId, title: title }, function(response) {
                    alert(response);
                    fetchQueue();
                });
            };

            // Função para buscar a fila de reprodução
            function fetchQueue() {
                $.get('fetch_queue.php', function(data) {
                    $('#queueList').empty();
                    data.forEach(function(item) {
                        $('#queueList').append(`<li>${item.title}</li>`);
                    });
                }, 'json');
            }

            // Carregar a fila ao carregar a página
            fetchQueue();

            // Botão para reproduzir a fila
            $('#playQueue').click(function() {
                window.location.href = 'play_queue.php';
            });
        });
    </script>
</body>
</html>
