// <?php
// header('Content-Type: application/json');

// $servername = "tccappionic-bd.mysql.uhserver.com";
// $username = "ionic_perfil_bd";
// $password = "{[UOLluiz2019";
// $dbname = "tccappionic_bd";

// // Cria a conexão
// $conn = new mysqli($servername, $username, $password, $dbname);

// // Verifica a conexão
// if ($conn->connect_error) {
//     echo json_encode(['error' => 'Erro na conexão: ' . $conn->connect_error]);
//     exit;
// }

// $id = $_GET['id'];

// $sql = "SELECT * FROM livros WHERE id = ?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("i", $id);
// $stmt->execute();
// $result = $stmt->get_result();

// if ($result->num_rows > 0) {
//     echo json_encode($result->fetch_assoc());
// } else {
//     echo json_encode(['error' => 'Livro não encontrado.']);
// }

// $stmt->close();
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
    echo json_encode(['error' => 'Erro na conexão: ' . $conn->connect_error]);
    exit;
}

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id === null) {
    echo json_encode(['error' => 'ID não fornecido.']);
    exit;
}

$sql = "SELECT * FROM livros WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $livro = $result->fetch_assoc();
    
    // Se a imagem for armazenada em base64, converta aqui
    if ($livro['imagem']) {
        $livro['imagem'] = 'data:image/jpeg;base64,' . base64_encode($livro['imagem']);
    }

    echo json_encode($livro);
} else {
    echo json_encode(['error' => 'Livro não encontrado.']);
}

$stmt->close();
$conn->close();
?>
