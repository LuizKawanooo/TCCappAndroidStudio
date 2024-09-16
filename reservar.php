<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$servername = "tccappionic-bd.mysql.uhserver.com"; // ou o endereço do seu servidor
$username = "ionic_perfil_bd"; // seu nome de usuário
$password = "{[UOLluiz2019"; // sua senha
$dbname = "tccappionic_bd";

// Conectar ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

// Ler horários e reservas
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = "SELECT h.horario, r.status, r.computador_id, r.btnVermelho, r.reserva_time 
              FROM horarios h 
              LEFT JOIN reservas r ON h.id = r.horario_id";
    
    $result = $conn->query($query);
    
    if ($result === false) {
        echo json_encode(["success" => false, "message" => "Error executing query: " . $conn->error]);
        exit;
    }
    
    $horarios = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($horarios);
    exit;
}

// Atualizar status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $horario = $data['horario'];
    $computadorId = $data['computador_id'];
    
    if (isset($horario) && isset($computadorId)) {
        // Obter o ID do horário
        $stmt = $conn->prepare("SELECT id FROM horarios WHERE horario = ?");
        if ($stmt === false) {
            echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
            exit;
        }
        $stmt->bind_param("s", $horario);
        $stmt->execute();
        $stmt->bind_result($horarioId);
        $stmt->fetch();
        $stmt->close();
        
        if (!$horarioId) {
            echo json_encode(["success" => false, "message" => "Horário não encontrado"]);
            exit;
        }
        
        // Verificar se o horário foi reservado recentemente
        $stmt = $conn->prepare("SELECT reserva_time FROM reservas WHERE horario_id = ? AND computador_id = ?");
        if ($stmt === false) {
            echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
            exit;
        }
        $stmt->bind_param("ii", $horarioId, $computadorId);
        $stmt->execute();
        $stmt->bind_result($reservaTime);
        $stmt->fetch();
        $stmt->close();
        
        if ($reservaTime) {
            $currentTime = new DateTime();
            $reservationTime = new DateTime($reservaTime);
            $interval = $currentTime->diff($reservationTime);
            $minutesPassed = ($interval->h * 60) + $interval->i;
            
            if ($minutesPassed < 30) {
                echo json_encode(["success" => false, "message" => "Horário reservado recentemente. Tente novamente mais tarde."]);
                exit;
            }
        }
        
        // Atualizar status para todos os computadores e definir botão vermelho
        $stmt = $conn->prepare("INSERT INTO reservas (computador_id, horario_id, status, btnVermelho, reserva_time) VALUES (?, ?, 1, 'Sim', NOW())
                                ON DUPLICATE KEY UPDATE status = 1, btnVermelho = 'Sim', reserva_time = NOW()");
        if ($stmt === false) {
            echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
            exit;
        }
        $stmt->bind_param("ii", $computadorId, $horarioId);
        $stmt->execute();
        $stmt->close();
        
        echo json_encode(["success" => true]);
        exit;
    } else {
        echo json_encode(["success" => false, "message" => "Invalid input"]);
        exit;
    }
}

$conn->close();
?>
