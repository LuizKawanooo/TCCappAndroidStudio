<?php
// Verificar o método da solicitação
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST' || $method === 'GET') {
    // Obter parâmetros conforme o método
    $destinatario = $method === 'POST' ? $_POST['email'] ?? null : $_GET['email'] ?? null;
    $conteudo = $method === 'POST' ? $_POST['content'] ?? null : $_GET['content'] ?? null;

    if ($destinatario && $conteudo) {
        $assunto = "Recuperação de Senha";
        $remetente = "juviscreudo19@gmail.com"; // Remetente do e-mail
        $cabecalho = "From: " . $remetente . "\r\n"; // Cabeçalho do e-mail

        // Enviar o e-mail
        $resultado = mail($destinatario, $assunto, $conteudo, $cabecalho);

        if ($resultado) {
            // Se o e-mail foi enviado com sucesso
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'E-mail enviado com sucesso']);
        } else {
            // Se houve falha ao enviar o e-mail
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Erro ao enviar e-mail']);
        }
    } else {
        // Se os parâmetros estão ausentes
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Parâmetros ausentes']);
    }
} else {
    // Se o método não for GET ou POST
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Método não permitido']);
}
?>
