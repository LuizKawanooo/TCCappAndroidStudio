// <?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");

// // Configurações do banco de dados
// $host = "tccappionic-bd.mysql.uhserver.com";
// $dbname = "tccappionic_bd";
// $username = "ionic_perfil_bd";
// $password = "{[UOLluiz2019";

// try {
//     // Conectar ao banco de dados
//     $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//     echo "Conectado ao banco de dados.<br>"; // Mensagem de depuração

//     // Consulta SQL para buscar todos os artigos
//     $sql = "SELECT id, titulo, descricao, pdf_nome, data_publicacao FROM artigos";
//     $stmt = $pdo->prepare($sql);
//     $stmt->execute();
    
//     echo "Consulta executada.<br>"; // Mensagem de depuração
    
//     $artigos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
//     if ($artigos) {
//         echo json_encode($artigos);
//     } else {
//         echo json_encode(array("message" => "Nenhum artigo encontrado."));
//     }
// } catch (PDOException $e) {
//     echo "Erro ao consultar o banco de dados: " . $e->getMessage();
// }
// ?>






<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Configurações do banco de dados
$host = "tccappionic-bd.mysql.uhserver.com";
$dbname = "tccappionic_bd";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";

try {
    // Cria uma conexão com o banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conectado ao banco de dados.<br>";

    // Prepara e executa a consulta SQL
    $sql = "SELECT id, titulo, descricao, pdf_nome, data_publicacao FROM artigos";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Recupera todos os registros como um array associativo
    $artigos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Verifica se há artigos e os retorna como JSON
    if ($artigos) {
        echo json_encode($artigos);
    } else {
        echo json_encode(array("message" => "Nenhum artigo encontrado."));
    }
} catch (PDOException $e) {
    // Exibe mensagens de erro em caso de falha na consulta
    echo "Erro ao consultar o banco de dados: " . $e->getMessage();
}
?>
