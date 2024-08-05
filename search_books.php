<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(array("message" => "Connection failed: " . $conn->connect_error));
    exit();
}

// Get search query from the query parameter
$searchQuery = isset($_GET['query']) ? $conn->real_escape_string($_GET['query']) : '';

// Ensure the search query is valid
if (empty($searchQuery)) {
    echo json_encode(array("message" => "Search query cannot be empty"));
    $conn->close();
    exit();
}

// Query to search for books
$sql = "SELECT `id`, `titulo`, `genero`, `autor`, `editora`, `tombo`, `ano`, `classificacao`, `n_paginas`, `isbn`, `sinopse` 
        FROM livros 
        WHERE `titulo` LIKE ? OR `autor` LIKE ?";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(array("message" => "Failed to prepare the SQL statement: " . $conn->error));
    $conn->close();
    exit();
}

$searchParam = "%$searchQuery%";
$stmt->bind_param("ss", $searchParam, $searchParam);
$stmt->execute();
$result = $stmt->get_result();

$books = array();
while ($row = $result->fetch_assoc()) {
    $books[] = $row;
}

if (count($books) > 0) {
    echo json_encode($books);
} else {
    echo json_encode(array("message" => "No books found"));
}

$stmt->close();
$conn->close();
?>
