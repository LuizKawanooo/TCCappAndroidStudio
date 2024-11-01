<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(array("error" => "Falha na conexão com o banco de dados: " . $conn->connect_error)));
}

// Verificar se o RM foi fornecido
$rm = isset($_GET['rm']) ? $_GET['rm'] : '';

if (!empty($rm)) {
    $sql = "SELECT imagem_perfil FROM registrar_usuarios WHERE rm = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die(json_encode(array("error" => "Falha ao preparar a consulta: " . $conn->error)));
    }

    $stmt->bind_param("s", $rm); // Bind do RM como string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Verifica se a imagem existe
        if ($row["imagem_perfil"]) {
            echo json_encode(array(
                "success" => true,
                "image_url" => 'data:image/jpeg;base64,' . base64_encode($row["imagem_perfil"])
            ));
        } else {
            echo json_encode(array("success" => false, "message" => "Imagem de perfil não disponível."));
        }
    } else {
        echo json_encode(array("success" => false, "message" => "Usuário não encontrado."));
    }

    $stmt->close();
} else {
    echo json_encode(array("success" => false, "message" => "RM inválido."));
}

$conn->close();
?>
