// <?php
// // Enable error reporting
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// header('Content-Type: application/json');
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
// header('Access-Control-Allow-Headers: Content-Type');

// $servername = "tccappionic-bd.mysql.uhserver.com";
// $username = "ionic_perfil_bd";
// $password = "{[UOLluiz2019";
// $dbname = "tccappionic_bd";

// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);

// // Check connection
// if ($conn->connect_error) {
//     echo json_encode(array("message" => "Connection failed: " . $conn->connect_error));
//     exit();
// }

// // Get user ID from query parameters
// $data = json_decode(file_get_contents("php://input"), true);
// $userId = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

// // Ensure the user ID is valid
// if ($userId <= 0) {
//     echo json_encode(array("message" => "Invalid user ID"));
//     $conn->close();
//     exit();
// }

// // Query to add 100 points to the user’s points
// $updateSql = "UPDATE registrar_usuarios SET pontos = pontos + 100 WHERE id = ?";
// $updateStmt = $conn->prepare($updateSql);

// if ($updateStmt === false) {
//     echo json_encode(array("message" => "Failed to prepare the SQL update statement: " . $conn->error));
//     $conn->close();
//     exit();
// }

// // Bind the user ID to the query
// $updateStmt->bind_param("i", $userId);
// $updateStmt->execute();

// if ($updateStmt->affected_rows > 0) {
//     echo json_encode(array("message" => "100 points added successfully"));
// } else {
//     // Check if the user exists
//     if ($conn->affected_rows === 0) {
//         echo json_encode(array("message" => "User not found or points not updated"));
//     } else {
//         echo json_encode(array("message" => "Failed to add points, please try again later"));
//     }
// }

// $updateStmt->close();
// $conn->close();
// ?>



<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die(json_encode(array("status" => "error", "message" => "Falha na conexão: " . $conn->connect_error)));
}

// Recebe dados enviados no corpo da requisição
$data = json_decode(file_get_contents("php://input"), true);

// Verifica se userId foi passado
$userId = isset($data['userId']) ? intval($data['userId']) : 0;
$pointsToAdd = 100; // Define pontos a serem adicionados como fixo

// Valida dados
if ($userId <= 0 || $pointsToAdd <= 0) {
    echo json_encode(array("status" => "error", "message" => "Dados inválidos."));
    $conn->close();
    exit();
}

// Atualiza os pontos do usuário
$sql = "UPDATE registrar_usuarios SET pontos = pontos + ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $pointsToAdd, $userId);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) { // Verifica se a linha foi realmente afetada
        echo json_encode(array("status" => "success", "message" => "Pontos adicionados com sucesso."));
    } else {
        echo json_encode(array("status" => "error", "message" => "Nenhuma linha atualizada. Verifique se o ID do usuário é válido."));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Erro ao adicionar pontos: " . $stmt->error));
}

$stmt->close();
$conn->close();
?>
