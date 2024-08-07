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

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtém o parâmetro de gênero da URL
$genre = isset($_GET['genre']) ? $_GET['genre'] : '';

// Prepara a consulta SQL, considerando o parâmetro de gênero
$sql = "SELECT id, imagem, status_livros, genre FROM livros";
if ($genre) {
    $stmt = $conn->prepare("SELECT id, imagem, status_livros, genre FROM livros WHERE genre = ?");
    $stmt->bind_param("s", $genre);
} else {
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

$images = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $images[] = array(
            "id" => $row["id"],
            "image_url" => 'data:image/jpeg;base64,' . base64_encode($row["imagem"]),
            "status_livros" => $row["status_livros"],
            "genre" => $row["genre"]
        );
    }
    echo json_encode(array("images" => $images));
} else {
    echo json_encode(array("message" => "No images found"));
}

$conn->close();
?>
