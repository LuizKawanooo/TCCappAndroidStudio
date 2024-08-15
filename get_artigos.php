<?php

header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Allow these HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow these h




$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the SQL statement
    if ($stmt = $conn->prepare("SELECT pdf_nome, arquivo FROM artigos WHERE id = ?")) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($pdf_nome, $arquivo);
        $stmt->fetch();

        // Check if any result was found
        if ($stmt->num_rows > 0) {
            header("Content-Type: application/pdf");
            header("Content-Disposition: inline; filename=\"$pdf_nome\"");
            echo $arquivo;
        } else {
            // No result found
            http_response_code(404);
            echo "Arquivo não encontrado.";
        }

        $stmt->close();
    } else {
        // Error preparing the SQL statement
        http_response_code(500);
        echo "Erro ao preparar a consulta.";
    }
} else {
    // No ID provided
    http_response_code(400);
    echo "ID não fornecido.";
}

$conn->close();
?>
