<?php
// Configuração CORS
header("Access-Control-Allow-Origin: *"); // Permite qualquer origem
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Permite métodos HTTP
header("Access-Control-Allow-Headers: Content-Type"); // Permite cabeçalhos específicos
header("Content-Type: application/json");

// Verifica o método da requisição
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Responde a requisições OPTIONS
    http_response_code(200);
    exit;
}

// Recebe o corpo da solicitação
$data = json_decode(file_get_contents('php://input'), true);

// Verifica se o e-mail está presente
if (!isset($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['message' => 'E-mail inválido.']);
    exit;
}

// Configurações do banco de dados
$dsn = 'mysql:host=tccappionic-bd.mysql.uhserver.com;dbname=tccappionic_bd';
$username = 'ionic_perfil_bd';
$password = '{[UOLluiz2019';

try {
    // Conecta ao banco de dados
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Gera um token único
    $token = bin2hex(random_bytes(16));

    // Salva o token e o e-mail no banco de dados
    $statement = $pdo->prepare('INSERT INTO password_resets (email, token) VALUES (:email, :token)');
    $statement->execute(['email' => $data['email'], 'token' => $token]);

    // Define o link de redefinição de senha
    $resetLink = "AppIonicTCC://reset?token=$token";

    // Envia o e-mail
    $to = $data['email'];
    $subject = 'Redefinição de Senha';
    $message = "Clique no link para redefinir sua senha: $resetLink";
    $headers = 'From: no-reply@endologic.com.br' . "\r\n" .
               'Reply-To: no-reply@endologic.com.br' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(['message' => 'Link de redefinição enviado com sucesso.']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Erro ao enviar o e-mail.']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Erro ao conectar ao banco de dados: ' . $e->getMessage()]);
}
?>
