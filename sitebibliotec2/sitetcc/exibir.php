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

// Busca as imagens armazenadas
$sql = "SELECT * FROM plantas";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$plantas = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imagens Armazenadas</title>
</head>
<body>
    <h1>Imagens Armazenadas</h1>
    <?php if ($plantas): ?>
        <ul>
            <?php foreach ($plantas as $planta): ?>
                <li>
                    <img src="<?php echo htmlspecialchars($planta['imagem']); ?>" alt="Imagem" style="width: 100px;">
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Nenhuma imagem armazenada.</p>
    <?php endif; ?>
</body>
</html>
