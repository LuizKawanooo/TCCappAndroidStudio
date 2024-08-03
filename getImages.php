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
    die("Connection failed: " . $conn->connect_error);
}

// Atualiza o status da imagem
$updateSql = "UPDATE livros SET imagem_status = 'DISPONÍVEL2' WHERE id = 2";
if ($conn->query($updateSql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

// Seleciona as imagens
$sql = "SELECT id, imagem, imagem_status FROM livros";
$result = $conn->query($sql);

$images = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $images[] = [
            'id' => $row['id'],
            'image_url' => 'data:image/jpeg;base64,' . base64_encode($row['imagem']),
            'status' => $row['imagem_status']
        ];
    }
}

echo json_encode($images);

$conn->close();
?>
