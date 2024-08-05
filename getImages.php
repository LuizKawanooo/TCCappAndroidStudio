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

$searchTerm = isset($_GET['q']) ? '%' . $_GET['q'] . '%' : '%';

// Preparar a consulta SQL com parâmetros para pesquisa
$sql = "SELECT `id`, `titulo`, `genero`, `autor`, `editora`, `tombo`, `ano`, `classificacao`, `n_paginas`, `isbn`, `sinopse`, `status_livros`, `imagem`
        FROM livros 
        WHERE `titulo` LIKE ? OR `autor` LIKE ?";

// Preparar a consulta
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error preparing query: " . $conn->error);
}

// Associar parâmetros e executar
$stmt->bind_param('ss', $searchTerm, $searchTerm);
$stmt->execute();

// Obter resultados
$result = $stmt->get_result();

$books = array();
while ($row = $result->fetch_assoc()) {
    $books[] = array(
        "id" => $row["id"],
        "titulo" => $row["titulo"],
        "genero" => $row["genero"],
        "autor" => $row["autor"],
        "editora" => $row["editora"],
        "tombo" => $row["tombo"],
        "ano" => $row["ano"],
        "classificacao" => $row["classificacao"],
        "n_paginas" => $row["n_paginas"],
        "isbn" => $row["isbn"],
        "sinopse" => $row["sinopse"],
        "status_livros" => $row["status_livros"],
        "imagem" => 'data:image/jpeg;base64,' . base64_encode($row["imagem"])
    );
}

// Retornar resultados como JSON
echo json_encode(array("books" => $books));

// Fechar a conexão
$stmt->close();
$conn->close();
?>
