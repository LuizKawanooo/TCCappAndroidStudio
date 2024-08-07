// <?php
// header('Content-Type: application/json');
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
// header('Access-Control-Allow-Headers: Content-Type');

// $servername = "tccappionic-bd.mysql.uhserver.com";
// $username = "ionic_perfil_bd";
// $password = "{[UOLluiz2019";
// $dbname = "tccappionic_bd";

// $conn = new mysqli($servername, $username, $password, $dbname);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// $sql = "SELECT id, imagem, status_livros FROM livros";
// $result = $conn->query($sql);

// $images = array();

// if ($result->num_rows > 0) {
//     while($row = $result->fetch_assoc()) {
//         $images[] = array(
//             "id" => $row["id"],
//             "image_url" => 'data:image/jpeg;base64,' . base64_encode($row["imagem"]),
//             "status_livros" => $row["status_livros"]
//         );
//     }
//     echo json_encode(array("images" => $images));
// } else {
//     echo json_encode(array("message" => "No images found"));
// }

// $conn->close();
// ?>


<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Conectar ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die(json_encode(array("error" => "Connection failed: " . $conn->connect_error)));
}

// Obtém o parâmetro de gênero da URL
$genre = isset($_GET['genre']) ? $_GET['genre'] : '';

// Construir a consulta SQL
$sql = "SELECT id, imagem, status_livros FROM livros";
if ($genre) {
    // Certifique-se de que o nome da coluna no banco de dados é correto
    $sql .= " WHERE genero = ?";
}

$stmt = $conn->prepare($sql);

// Verificar se a preparação da consulta foi bem-sucedida
if ($stmt === false) {
    die(json_encode(array("error" => "Prepare failed: " . $conn->error)));
}

// Se um gênero foi fornecido, faz o bind do parâmetro
if ($genre) {
    $stmt->bind_param("s", $genre);
}

$stmt->execute();
$result = $stmt->get_result();

$images = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $images[] = array(
            "id" => $row["id"],
            "image_url" => 'data:image/jpeg;base64,' . base64_encode($row["imagem"]),
            "status_livros" => $row["status_livros"]
        );
    }
    echo json_encode(array("images" => $images));
} else {
    echo json_encode(array("message" => "No images found"));
}

$stmt->close();
$conn->close();
?>
