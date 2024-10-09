<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permite todas as origens

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

// Prepara a consulta para selecionar todos os dados do livro
$sql = "SELECT * FROM livros WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $livro = $result->fetch_assoc();
    
    // Se a imagem estiver presente e não estiver vazia, converta para base64
    if (isset($livro['imagem']) && !empty($livro['imagem'])) {
        $imagemPath = $livro['imagem'];
        
        // Debug: exibe o caminho da imagem
        error_log("Caminho da imagem: " . $imagemPath);

        // Verifica se o arquivo de imagem existe
        if (file_exists($imagemPath)) {
            $imagemData = file_get_contents($imagemPath);
            $livro['imagem'] = 'data:image/jpeg;base64,' . base64_encode($imagemData);
        } else {
            $livro['imagem'] = null; // ou uma string padrão se a imagem não existir
        }
    } else {
        $livro['imagem'] = null; // ou uma string padrão se a imagem não existir
    }

    echo json_encode($livro);
} else {
    echo json_encode(['error' => 'Livro não encontrado.']);
}

$stmt->close();
$conn->close();
?>
