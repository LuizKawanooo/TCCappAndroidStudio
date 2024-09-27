<?php
// Conexão com o banco de dados (substitua com suas credenciais)
$host = 'tccappionic-bd.mysql.uhserver.com';
$db   = 'tccappionic_bd';
$user = 'ionic_perfil_bd';
$pass = '{[UOLluiz2019';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    die('Erro na conexão: ' . $e->getMessage());
}

// Inicializa a variável de mensagem
$mensagem = '';

// Processar o upload de imagem
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    
    // Verificar se o upload foi feito sem erros
    if ($file['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/'; // Pasta para armazenar imagens
        $filePath = $uploadDir . basename($file['name']);
        
        // Mover o arquivo para o diretório desejado
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            // Inserir no banco de dados
            $stmt = $pdo->prepare("INSERT INTO plantas (nome, caminho) VALUES (?, ?)");
            $stmt->execute([$file['name'], $filePath]);
            $mensagem = "Imagem carregada com sucesso!";
        } else {
            $mensagem = "Erro ao mover o arquivo.";
        }
    } else {
        $mensagem = "Erro no upload do arquivo.";
    }
}

// Exibir a imagem mais recente
$sql = "SELECT * FROM plantas ORDER BY criado_em DESC LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$imagem = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliotec - Upload de Planta</title>
    <link rel="shortcut icon" href="img/logo.png">
</head>
<body>

    <style>
        /* Estilos omitidos para brevidade */
    </style>

    <form action="" method="POST" enctype="multipart/form-data">
        <label class="custum-file-upload" for="file">
            <div class="icon">
                <!-- SVG ou ícone aqui -->
            </div>
            <div class="text">
                <span>Click to upload image</span>
            </div>
            <input type="file" name="file" id="file" required>
        </label>
        <button type="submit">Upload</button>
    </form>

    <?php if ($mensagem): ?>
        <p><?php echo $mensagem; ?></p>
    <?php endif; ?>

    <?php if ($imagem): ?>
        <h2>Imagem Atual:</h2>
        <img src="<?php echo $imagem['caminho']; ?>" alt="<?php echo $imagem['nome']; ?>" style="max-width: 100%;">
    <?php endif; ?>

    <button onclick="openPopup()" id="btn1">Horários</button>
    <!-- Restante do código... -->
</body>
</html>
