<?php
// Configurações de cabeçalhos CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

// Conexão com o banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Consulta SQL para recuperar os artigos cadastrados
$sql = "SELECT * FROM artigos";
$result = $conn->query($sql);

$artigos = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $artigos[] = $row;
    }
}

$conn->close();

// Exibe os artigos em formato HTML
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artigos - TCC</title>
    <link rel="stylesheet" href="style.css"> <!-- Adicione seu CSS aqui -->
</head>
<body>

<div class="container">
    <h1>Artigos</h1>
    <?php if (!empty($artigos)): ?>
        <div class="artigos-list">
            <?php foreach ($artigos as $artigo): ?>
                <div class="artigo">
                    <h2><?php echo htmlspecialchars($artigo["titulo"]); ?></h2>
                    <p>Autor: <?php echo htmlspecialchars($artigo["autor"]); ?></p>
                    <p>Ano: <?php echo htmlspecialchars($artigo["ano"]); ?></p>
                    <a href="fetch_artigos.php?id=<?php echo $artigo['id']; ?>" class="btn-download">Download PDF</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Nenhum artigo encontrado.</p>
    <?php endif; ?>
</div>

</body>
</html>
