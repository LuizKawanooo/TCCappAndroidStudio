<?php
// Adicionar cabeçalhos CORS
header("Access-Control-Allow-Origin: *"); // Permitir todas as origens, ajuste conforme necessário
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Permitir métodos
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Permitir cabeçalhos específicos


$repoPath = '/var/www/html/TCCappAndroidStudio';
$branch = 'master';
$pdfDir = "$repoPath/pastaPdf";

// Altere para o caminho onde você clona seu repositório localmente
exec("git -C $repoPath pull origin $branch");

$files = glob("$pdfDir/*.pdf");
$pdfs = [];

foreach ($files as $file) {
    $pdfs[] = [
        'name' => basename($file),
        'path' => $file,
        'url' => "http://yourserver.com/path/to/$file"
    ];
}

header('Content-Type: application/json');
echo json_encode($pdfs);
?>
