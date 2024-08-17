<?php
// Permitir acesso de qualquer origem
header("Access-Control-Allow-Origin: *");

// Permitir métodos HTTP específicos
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

// Permitir cabeçalhos específicos
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Verifique se é uma solicitação OPTIONS e retorne a resposta adequada
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}




// upload.php

// Verifique se o arquivo foi enviado
if (isset($_FILES['pdf'])) {
    $file = $_FILES['pdf'];

    // Defina o diretório de upload
    $uploadDirectory = '/pastaPdf/';
    
    // Verifique se o diretório existe, se não, crie-o
    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    // Gere um nome único para o arquivo para evitar conflitos
    $fileName = uniqid() . '-' . basename($file['name']);
    $uploadPath = $uploadDirectory . $fileName;

    // Mova o arquivo para o diretório de upload
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        // Resposta de sucesso
        echo json_encode(['status' => 'success', 'message' => 'PDF uploaded successfully!']);
    } else {
        // Resposta de erro
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload PDF.']);
    }
} else {
    // Resposta de erro
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'No PDF file uploaded.']);
}
