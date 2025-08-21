<?php
// Conexão com o banco
$servername = "";
$username = "";
$password = "";
$dbname = "";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Pegando o ID da ordem de serviço
$id = $_GET['id'];

// Consulta para pegar os dados da ordem de serviço
$query = "SELECT id, codigo_cliente, aparelho, marca, modelo, serie, acessorios, condicoes, defeito_informado, descricao_servico, entrega, garantia, valor, condicoes_pagamento, data_entrega, data_registro FROM ordem_servico WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode([]);
}

$conn->close();
?>
