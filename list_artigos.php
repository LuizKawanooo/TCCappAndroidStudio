<?php
// Rota para listar todos os PDFs dos artigos
$app->get('/artigos', function ($request, $response, $args) {
    // Conecte-se ao banco de dados
    try {
        $db = new PDO('mysql:host=tccappionic-bd.mysql.uhserver.com;dbname=tccappionic_bd;charset=utf8', 'ionic_perfil_bd', '{[UOLluiz2019');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        return $response->withStatus(500)->write('Erro de conexão com o banco de dados: ' . $e->getMessage());
    }

    // Query para buscar todos os artigos
    $stmt = $db->query('SELECT id, pdf_nome FROM artigos');
    $artigos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($artigos) {
        return $response->withJson($artigos);
    } else {
        return $response->withStatus(404)->write('Nenhum artigo encontrado');
    }
});
