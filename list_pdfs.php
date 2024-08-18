// <?php
// // Adicionar cabeçalhos CORS
// header("Access-Control-Allow-Origin: *"); // Permitir todas as origens, ajuste conforme necessário
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Permitir métodos
// header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Permitir cabeçalhos específicos


// // URL da API do GitHub para listar o conteúdo do diretório
// $apiUrl = 'https://api.github.com/repos/LuizKawanooo/TCCappAndroidStudio/contents/pastaPdf';

// // Inicializa cURL
// $ch = curl_init();

// // Define as opções do cURL
// curl_setopt($ch, CURLOPT_URL, $apiUrl);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_USERAGENT, 'MyApp'); // GitHub requer um User-Agent

// // Executa a solicitação e obtém a resposta
// $response = curl_exec($ch);

// // Verifica se houve erro
// if(curl_errno($ch)) {
//     die("Erro ao acessar a API do GitHub: " . curl_error($ch));
// }

// // Fecha a conexão cURL
// curl_close($ch);

// // Decodifica o JSON retornado pela API
// $files = json_decode($response, true);
// $pdfs = [];

// foreach ($files as $file) {
//     if (isset($file['name']) && substr($file['name'], -4) === '.pdf') {
//         $pdfs[] = [
//             'name' => $file['name'],
//             'url' => $file['download_url'] // URL para download do arquivo
//         ];
//     }
// }

// header('Content-Type: application/json');
// echo json_encode($pdfs);
// ?>








<?php
// Adicionar cabeçalhos CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// URL da API do GitHub para listar o conteúdo do diretório
$apiUrl = 'https://api.github.com/repos/LuizKawanooo/TCCappAndroidStudio/contents/pastaPdf';

// Inicializa cURL
$ch = curl_init();

// Define as opções do cURL
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'MyApp');

// Executa a solicitação e obtém a resposta
$response = curl_exec($ch);

// Verifica se houve erro
if (curl_errno($ch)) {
    die("Erro ao acessar a API do GitHub: " . curl_error($ch));
}

// Fecha a conexão cURL
curl_close($ch);

// Decodifica o JSON retornado pela API
$files = json_decode($response, true);
$categories = ['Administração', 'Contabilidade', 'Desenvolvimento de Sistemas'];
$categoryPdfs = [];

// Inicializa arrays para cada categoria
foreach ($categories as $category) {
    $categoryPdfs[$category] = [];
}

// Organiza PDFs por categoria
foreach ($files as $file) {
    if ($file['type'] === 'dir') {
        $category = $file['name'];
        if (in_array($category, $categories)) {
            $categoryApiUrl = $file['url'];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $categoryApiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, 'MyApp');
            $categoryResponse = curl_exec($ch);
            curl_close($ch);

            $categoryFiles = json_decode($categoryResponse, true);
            foreach ($categoryFiles as $pdfFile) {
                if (isset($pdfFile['name']) && substr($pdfFile['name'], -4) === '.pdf') {
                    $categoryPdfs[$category][] = [
                        'name' => $pdfFile['name'],
                        'url' => $pdfFile['download_url']
                    ];
                }
            }
        }
    }
}

header('Content-Type: application/json');
echo json_encode($categoryPdfs);
?>
