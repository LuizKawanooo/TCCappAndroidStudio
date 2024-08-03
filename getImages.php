// <?php
// // Habilitar exibição de erros
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// header('Content-Type: application/json');
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
// header('Access-Control-Allow-Headers: Origin, Content-Type, Accept');

// $servername = "tccappionic-bd.mysql.uhserver.com";
// $username = "ionic_perfil_bd";
// $password = "{[UOLluiz2019";
// $dbname = "tccappionic_bd";

// // Cria a conexão
// $conn = new mysqli($servername, $username, $password, $dbname);

// // Verifica a conexão
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// // Consulta SQL para selecionar imagens e status
// $sql = "SELECT id, imagem, imagem_status FROM livros";
// $result = $conn->query($sql);

// $images = [];

// if ($result->num_rows > 0) {
//     while ($row = $result->fetch_assoc()) {
//         $images[] = [
//             'id' => $row['id'],
//             'image_url' => 'data:image/jpeg;base64,' . base64_encode($row['imagem']),
//             'status' => $row['imagem_status']
//         ];
//     }
// } else {
//     echo json_encode([]); // Se não houver resultados, retorne uma matriz vazia
//     exit(); // Certifique-se de sair para evitar que mais código seja executado
// }

// // Retorna os resultados no formato JSON
// echo json_encode($images);

// $conn->close();
// ?>













<?php
header('Content-Type: application/json');

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta para pegar as imagens
$sql = "SELECT id, image_url, description, livro_status FROM images";
$result = $conn->query($sql);

$images = array();

if ($result->num_rows > 0) {
    // Dados das imagens
    while($row = $result->fetch_assoc()) {
        $images[] = $row;
    }
} else {
    echo "0 resultados";
}

// Fecha a conexão
$conn->close();

// Retorna as imagens em formato JSON
echo json_encode(array("images" => $images));
?>
