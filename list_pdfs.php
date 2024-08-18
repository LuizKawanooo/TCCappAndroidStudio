<?php
// Adicionar cabeçalhos CORS
header("Access-Control-Allow-Origin: *"); // Permitir todas as origens, ajuste conforme necessário
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Permitir métodos
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Permitir cabeçalhos específicos


// Caminho para o repositório GitHub Pages
$repoPath = 'https://luizkawanooo.github.io/TCCappAndroidStudio/pastaPdf';

// URL da API do GitHub para listar o conteúdo do diretório
$apiUrl = "https://api.github.com/repos/LuizKawanooo/TCCappAndroidStudio/contents/pastaPdf";

// Definir o User-Agent para a solicitação (obrigatório para a API do GitHub)
$options = [
    "http" => [
        "header" => "User-Agent: MyApp\r\n"
    ]
];
$context = stream_context_create($options);

// Obter o conteúdo do diretório usando a API do GitHub
$response = file_get_contents($apiUrl, false, $context);
if ($response === FALSE) {
    die("Erro ao acessar a API do GitHub.");
}

// Decodificar o JSON retornado pela API
$files = json_decode($response, true);
$pdfs = [];

foreach ($files as $file) {
    if (isset($file['name']) && substr($file['name'], -4) === '.pdf') {
        $pdfs[] = [
            'name' => $file['name'],
            'url' => $file['download_url'] // URL para download do arquivo
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($pdfs);
?>
