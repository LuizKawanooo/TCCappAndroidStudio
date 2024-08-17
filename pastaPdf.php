<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

if (isset($_FILES['pdf'])) {
    $file = $_FILES['pdf'];
    $uploadDirectory = __DIR__ . '/pastaPdf/';

    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    $fileName = uniqid() . '-' . basename($file['name']);
    $uploadPath = $uploadDirectory . $fileName;

    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        echo json_encode(['status' => 'success', 'message' => 'PDF uploaded successfully!', 'file_path' => $uploadPath]);
    } else {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload PDF.']);
    }
} else {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'No PDF file uploaded.']);
}
