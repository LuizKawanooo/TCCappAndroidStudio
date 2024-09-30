<?php
// Configurações do banco de dados
$host = 'tccappionic-bd.mysql.uhserver.com';
$db   = 'tccappionic_bd';
$user = 'ionic_perfil_bd';
$pass = '{[UOLluiz2019';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erro na conexão: ' . $e->getMessage());
}

// Verifica se o formulário de upload foi enviado
if (isset($_POST['upload'])) {
    // Verifica se a imagem foi enviada
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
        // Define o nome da planta como "Imagemm"
        $nomePlanta = "Imagemm"; 

        $targetDir = "uploads/"; // Pasta onde a imagem será salva
        $targetFile = $targetDir . basename($_FILES['imagem']['name']);

        // Verifica se o arquivo já existe
        if (file_exists($targetFile)) {
            echo "Desculpe, arquivo já existe.";
            exit;
        }

        // Permite certos formatos de arquivo
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Desculpe, apenas arquivos JPG, JPEG, PNG & GIF são permitidos.";
            exit;
        }

        // Tenta mover o arquivo enviado para o diretório especificado
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $targetFile)) {
            // Insere o caminho da imagem e o nome da planta no banco de dados
            $sql = "INSERT INTO plantas (nome, imagem) VALUES (?, ?)";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$nomePlanta, $targetFile])) {
                // Redireciona para uma página de sucesso ou a página principal
                header("Location: computadores.php?message=Upload realizado com sucesso!");
                exit;
            } else {
                echo "Erro ao armazenar no banco de dados.";
            }
        } else {
            echo "Desculpe, ocorreu um erro ao mover seu arquivo.";
        }
    } else {
        echo "Nenhum arquivo foi enviado ou ocorreu um erro.";
    }
}
?>
