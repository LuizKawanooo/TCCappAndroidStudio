// <?php

// // Adiciona cabeçalhos CORS
// header("Access-Control-Allow-Origin: *"); // Permite acesso de qualquer origem
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Permite os métodos usados
// header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Permite os cabeçalhos usados

// // Verificação se é uma requisição OPTIONS
// if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
//     http_response_code(200);
//     exit;
// }


// // Conexão com o banco de dados
// $host = 'tccappionic-bd.mysql.uhserver.com';
// $user = 'ionic_perfil_bd';
// $password = '{[UOLluiz2019';
// $db = 'tccappionic_bd';

// $conn = new mysqli($host, $user, $password, $db);

// if ($conn->connect_error) {
//     die("Falha na conexão: " . $conn->connect_error);
// }

// // Receber os dados da requisição
// $idComputador = $_POST['id_computador'];
// $horario = $_POST['horario'];
// $email = $_POST['email'];

// // Obter a hora atual
// $dataHoraAtual = new DateTime();
// $horaAtual = $dataHoraAtual->format('H:i');

// // Verificar se o horário selecionado é no passado
// if ($horario < $horaAtual) {
//     echo json_encode(['status' => 'error', 'message' => 'O horário selecionado é no passado e não pode ser reservado.']);
//     exit;
// }

// // Verificar o status do horário selecionado
// $sql = "SELECT * FROM reservas_computadores WHERE id_computador = ? AND horario = ?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("is", $idComputador, $horario);
// $stmt->execute();
// $result = $stmt->get_result();

// if ($result->num_rows > 0) {
//     $row = $result->fetch_assoc();
//     if ($row['status'] === 'reservado' && $dataHoraAtual < new DateTime($row['fim_reserva'])) {
//         echo json_encode(['status' => 'error', 'message' => 'O horário está atualmente reservado.']);
//         exit;
//     }
// }

// // Definir a reserva
// $inicioReserva = $dataHoraAtual->format('Y-m-d H:i:s');
// $fimReserva = $dataHoraAtual->modify('+30 seconds')->format('Y-m-d H:i:s');

// $sql = "INSERT INTO reservas_computadores (id_computador, horario, status, inicio_reserva, fim_reserva, email)
//         VALUES (?, ?, 'reservado', ?, ?, ?)
//         ON DUPLICATE KEY UPDATE status = 'reservado', inicio_reserva = ?, fim_reserva = ?, email = ?";

// $stmt = $conn->prepare($sql);
// $stmt->bind_param("isssssss", $idComputador, $horario, $inicioReserva, $fimReserva, $email, $inicioReserva, $fimReserva, $email);
// $stmt->execute();

// echo json_encode(['status' => 'success', 'message' => 'Reserva feita com sucesso! O horário será liberado após 30 segundos.']);

// // Fechar a conexão
// $conn->close();
// ?>











<?php

// Adiciona cabeçalhos CORS
header("Access-Control-Allow-Origin: *"); // Permite acesso de qualquer origem
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Permite os métodos usados
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Permite os cabeçalhos usados

// Verificação se é uma requisição OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Conexão com o banco de dados
$host = 'tccappionic-bd.mysql.uhserver.com';
$user = 'ionic_perfil_bd';
$password = '{[UOLluiz2019';
$db = 'tccappionic_bd';

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Se for uma requisição GET, retorna os horários
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $idComputador = $_GET['id_computador'];
    
    $sql = "SELECT horario, status FROM reservas_computadores WHERE id_computador = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idComputador);
    $stmt->execute();
    $result = $stmt->get_result();

    $horarios = [];
    while ($row = $result->fetch_assoc()) {
        $horarios[] = $row;
    }
    
    echo json_encode($horarios);
    exit;
}

// Receber os dados da requisição POST
$idComputador = $_POST['id_computador'];
$horario = $_POST['horario'];
$email = $_POST['email'];

// Obter a hora atual
$dataHoraAtual = new DateTime();
$horaAtual = $dataHoraAtual->format('H:i');

// Verificar se o horário selecionado é no passado
if ($horario < $horaAtual) {
    echo json_encode(['status' => 'error', 'message' => 'O horário selecionado é no passado e não pode ser reservado.']);
    exit;
}

// Verificar o status do horário selecionado
$sql = "SELECT * FROM reservas_computadores WHERE id_computador = ? AND horario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $idComputador, $horario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['status'] === 'reservado' && $dataHoraAtual < new DateTime($row['fim_reserva'])) {
        echo json_encode(['status' => 'error', 'message' => 'O horário está atualmente reservado.']);
        exit;
    }
}

// Definir a reserva
$inicioReserva = $dataHoraAtual->format('Y-m-d H:i:s');
$fimReserva = $dataHoraAtual->modify('+30 seconds')->format('Y-m-d H:i:s');

$sql = "INSERT INTO reservas_computadores (id_computador, horario, status, inicio_reserva, fim_reserva, email)
        VALUES (?, ?, 'reservado', ?, ?, ?)
        ON DUPLICATE KEY UPDATE status = 'reservado', inicio_reserva = ?, fim_reserva = ?, email = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("isssssss", $idComputador, $horario, $inicioReserva, $fimReserva, $email, $inicioReserva, $fimReserva, $email);
$stmt->execute();

echo json_encode(['status' => 'success', 'message' => 'Reserva feita com sucesso! O horário será liberado após 30 segundos.']);

// Fechar a conexão
$conn->close();
?>

