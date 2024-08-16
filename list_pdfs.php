<?php


// Adiciona cabeçalhos CORS
header("Access-Control-Allow-Origin: *"); // Permite todas as origens. Substitua "*" por um domínio específico se desejar mais segurança.
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");



$host = 'tccappionic-bd.mysql.uhserver.com';
$db   = 'tccappionic_bd';
$user = 'ionic_perfil_bd';
$pass = '{[UOLluiz2019';

// Verificar se o ID foi passado na URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    try {
        // Conectar ao banco de dados
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Preparar e executar a consulta para obter o PDF
        $stmt = $pdo->prepare('SELECT pdf_name, pdf_data FROM artigos WHERE id = ?');
        $stmt->execute([$id]);

        // Verificar se o PDF foi encontrado
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Definir cabeçalhos para o PDF
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . $row['pdf_name'] . '"');
            header('Content-Length: ' . strlen($row['pdf_data']));
            echo $row['pdf_data'];
        } else {
            header('HTTP/1.0 404 Not Found');
            echo "PDF não encontrado.";
        }
    } catch (PDOException $e) {
        header('HTTP/1.0 500 Internal Server Error');
        echo "Erro: " . $e->getMessage();
    }
} else {
    header('HTTP/1.0 400 Bad Request');
    echo "ID inválido.";
}
?>
