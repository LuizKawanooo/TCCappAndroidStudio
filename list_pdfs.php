<?php
// Adicionar cabeçalhos CORS
header("Access-Control-Allow-Origin: *"); // Permitir todas as origens, ajuste conforme necessário
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Permitir métodos
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Permitir cabeçalhos específicos


$repoPath = '/var/www/html/TCCappAndroidStudio';
// Branch que você deseja utilizar (normalmente 'master' ou 'main')
$branch = 'master';

// Caminho para a pasta onde os PDFs estão armazenados
$pdfDir = "$repoPath/pastaPdf"; // Substitua "pastaPdf" com o nome da pasta onde estão os PDFs

// Puxar as últimas mudanças do repositório
exec("git -C $repoPath pull origin $branch");

// Listar todos os PDFs na pasta especificada
$files = glob("$pdfDir/*.pdf");
$pdfs = [];

foreach ($files as $file) {
    $relativePath = str_replace($repoPath, '', $file); // Caminho relativo para a URL
    $pdfs[] = [
        'name' => basename($file),
        'path' => $file,
        'url' => "https://endologic.com.br/tcc" . $relativePath
    ];
}

header('Content-Type: application/json');
echo json_encode($pdfs);
?>
