// <?php
// header("Access-Control-Allow-Origin: *"); // Permite requisições de qualquer origem

// $apiKey = 'AIzaSyB5OpyEuIekeMW6zLr8DdE0qbnJPD5OfRU';
// $query = urlencode($_GET['query']);
// $maxResults = 5;
// $apiUrl = "https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&q={$query}&maxResults={$maxResults}&key={$apiKey}";

// $response = file_get_contents($apiUrl);
// $results = json_decode($response, true);

// echo '<h1>Resultados da Pesquisa</h1>';
// echo '<ul>';
// foreach ($results['items'] as $item) {
//     $videoId = $item['id']['videoId'];
//     $title = $item['snippet']['title'];
//     echo "<li>{$title} <a href='queue.php?videoId={$videoId}&title=" . urlencode($title) . "'>Adicionar à Fila</a></li>";
// }
// echo '</ul>';
// echo '<a href="player.html">Ir para o Player</a>';
// ?>






<?php
header("Access-Control-Allow-Origin: *"); // Permite requisições de qualquer origem

$apiKey = 'SUA_CHAVE_DE_API_DO_YOUTUBE';
$query = urlencode($_GET['query']);
$maxResults = 5;
$apiUrl = "https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&q={$query}&maxResults={$maxResults}&key={$apiKey}";

$response = file_get_contents($apiUrl);
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
