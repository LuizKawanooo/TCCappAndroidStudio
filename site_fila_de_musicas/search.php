<?php
header("Access-Control-Allow-Origin: *"); // Permite requisições de qualquer origem

$apiKey = 'AIzaSyB5OpyEuIekeMW6zLr8DdE0qbnJPD5OfRU';
$query = urlencode($_GET['query']);
$maxResults = 5;
$apiUrl = "https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&q={$query}&maxResults={$maxResults}&key={$apiKey}";

// Inicializa a sessão cURL
$ch = curl_init();

// Configurações da requisição cURL
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Executa a requisição e obtém a resposta
$response = curl_exec($ch);

// Verifica se houve erro na requisição
if ($response === false) {
    echo 'Erro na requisição: ' . curl_error($ch);
    curl_close($ch);
    exit;
}

// Fecha a sessão cURL
curl_close($ch);

// Decodifica a resposta JSON
$results = json_decode($response, true);

echo '<h1>Resultados da Pesquisa</h1>';

if (isset($results['items']) && is_array($results['items'])) {
    echo '<ul>';
    foreach ($results['items'] as $item) {
        $videoId = $item['id']['videoId'];
        $title = $item['snippet']['title'];
        echo "<li>{$title} <a href='queue.php?videoId={$videoId}&title=" . urlencode($title) . "'>Adicionar à Fila</a></li>";
    }
    echo '</ul>';
} else {
    echo 'Nenhum resultado encontrado ou ocorreu um erro na solicitação.';
}

echo '<a href="player.html">Ir para o Player</a>';

?>
