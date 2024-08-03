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
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept');

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

$sql = "SELECT id, imagem, imagem_status FROM livros";
$result = $conn->query($sql);

if (!$result) {
    echo json_encode(['error' => 'Query failed: ' . $conn->error]);
    exit();
}

$images = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Certifique-se de que a imagem está em um formato binário válido
        $imageData = $row['imagem'];
        $imageBase64 = base64_encode($imageData);
        
        // Defina o tipo da imagem com base na extensão
        $imageType = 'image/jpeg';  // Definição padrão
        if (strpos($row['imagem'], 'PNG') !== false) {
            $imageType = 'image/png';
        } elseif (strpos($row['imagem'], 'GIF') !== false) {
            $imageType = 'image/gif';
        }

        $images[] = [
            'id' => $row['id'],
            'image_url' => 'data:' . $imageType . ';base64,' . $imageBase64,
            'status' => $row['imagem_status']
        ];
    }
}

echo json_encode($images);

$conn->close();
?>
