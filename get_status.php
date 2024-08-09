// <?php
// header('Content-Type: application/json');
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: GET');
// header('Access-Control-Allow-Headers: Content-Type');

// $servername = "tccappionic-bd.mysql.uhserver.com";
// $username = "ionic_perfil_bd";
// $password = "{[UOLluiz2019";
// $dbname = "tccappionic_bd";

// $conn = new mysqli($servername, $username, $password, $dbname);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// $id = intval($_GET['id']);

// $sql = "SELECT status_livros FROM livros WHERE id = ?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("i", $id);
// $stmt->execute();
// $stmt->bind_result($status_livros);
// $stmt->fetch();
// $stmt->close();

// echo json_encode(['status_livros' => $status_livros]);

// $conn->close();
// ?>









<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Cria conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die(json_encode(['message' => 'Connection failed: ' . $conn->connect_error]));
}

// Verifica se o parâmetro id está presente
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Prepara e executa a consulta SQL
    $sql = "SELECT status_livros, rental_start_time FROM livros WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($status_livros, $rental_start_time);
    $stmt->fetch();
    
    // Verifica se o livro foi encontrado
    if ($status_livros !== null) {
        // Converte o tempo de início do aluguel para o formato de tempo UNIX
        $response = [
            'status_livros' => $status_livros,
            'rental_start_time' => $rental_start_time ? $rental_start_time : null
        ];
        echo json_encode($response);
    } else {
        echo json_encode(['message' => 'Book not found']);
    }
    
    $stmt->close();
} else {
    echo json_encode(['message' => 'Invalid or missing id']);
}

$conn->close();
?>
