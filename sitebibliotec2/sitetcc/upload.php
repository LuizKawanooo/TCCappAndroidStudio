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
            header("Location: computadores.php");
            exit;
        }

        // Permite certos formatos de arquivo
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Desculpe, apenas arquivos JPG, JPEG, PNG & GIF são permitidos.";
                            header("Location: computadores.php");
                    exit;
        }

        // Tenta mover o arquivo enviado para o diretório especificado
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $targetFile)) {
            // Verifica se já existe uma imagem para a planta
            $sqlSelect = "SELECT * FROM plantas WHERE nome = ?";
            $stmtSelect = $pdo->prepare($sqlSelect);
            $stmtSelect->execute([$nomePlanta]);

            if ($stmtSelect->rowCount() > 0) {
                // Se a imagem já existir, faz um UPDATE
                $sqlUpdate = "UPDATE plantas SET imagem = ? WHERE nome = ?";
                $stmtUpdate = $pdo->prepare($sqlUpdate);
                if ($stmtUpdate->execute([$targetFile, $nomePlanta])) {
                    header("Location: computadores.php?message=Imagem atualizada com sucesso!");
                    exit;
                } else {
                    echo "Erro ao atualizar a imagem no banco de dados.";
                    header("Location: computadores.php");
                    exit;
                }
            } else {
                // Se não existir, pode optar por não fazer nada ou inserir (caso desejado)
                // Aqui, se quiser inserir, descomente o código abaixo:
                /*
                $sqlInsert = "INSERT INTO plantas (nome, imagem) VALUES (?, ?)";
                $stmtInsert = $pdo->prepare($sqlInsert);
                if ($stmtInsert->execute([$nomePlanta, $targetFile])) {
                    header("Location: sucesso.php?message=Imagem inserida com sucesso!");
                    exit;
                } else {
                    echo "Erro ao armazenar no banco de dados.";
                }
                */
                echo "Nenhuma imagem foi encontrada para atualizar.";
                header("Location: computadores.php");
                    exit;
            }
        } else {
            echo "Desculpe, ocorreu um erro ao mover seu arquivo.";
            header("Location: computadores.php");
                    exit;
        }
    } else {
        echo "Nenhum arquivo foi enviado ou ocorreu um erro.";
        header("Location: computadores.php");
                    exit;
    }
}
?>
