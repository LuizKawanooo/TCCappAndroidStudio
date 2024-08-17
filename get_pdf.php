<?php
// Rota para obter o PDF de um artigo específico
$app->get('/artigos/{id}/pdf', function ($request, $response, $args) {
    $id = $args['id'];
    
    // Conecte-se ao banco de dados
    try {
        $db = new PDO('mysql:host=tccappionic-bd.mysql.uhserver.com;dbname=tccappionic_bd;charset=utf8', 'ionic_perfil_bd', '{[UOLluiz2019');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        return $response->withStatus(500)->write('Erro de conexão com o banco de dados: ' . $e->getMessage());
    }

    // Query para buscar o PDF
    $stmt = $db->prepare('SELECT arquivo, pdf_nome FROM artigos WHERE id = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $artigo = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($artigo) {
        $pdfContent = $artigo['arquivo'];  // Conteúdo binário do PDF
        $pdfName = $artigo['pdf_nome'];

        // Definir os cabeçalhos de resposta para o PDF
        $response = $response->withHeader('Content-Type', 'application/pdf')
                             ->withHeader('Content-Disposition', 'inline; filename="' . $pdfName . '"');

        // Enviar o conteúdo do PDF
        $response->getBody()->write($pdfContent);
        return $response;
    } else {
        return $response->withStatus(404)->write('PDF não encontrado');
    }
});
