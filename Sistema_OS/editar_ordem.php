<?php
// Conexão com o banco de dados
$host = 'bd-os-endo.mysql.uhserver.com';
$dbname = 'bd_os_endo';
$username = 'joseendologic';
$password = '{[OSluiz2019';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// Verificar se os dados foram enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo_cliente = $_POST['codigo_cliente'];
    $aparelho = $_POST['aparelho'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $serie = $_POST['serie'];
    $data_entrega = $_POST['data_entrega'];
    $valor = $_POST['valor'];

    // Atualizar os dados no banco
    $stmt = $pdo->prepare("UPDATE ordem_servico SET aparelho = :aparelho, marca = :marca, modelo = :modelo, serie = :serie, data_entrega = :data_entrega, valor = :valor WHERE codigo_cliente = :codigo_cliente");
    $stmt->bindParam(':aparelho', $aparelho);
    $stmt->bindParam(':marca', $marca);
    $stmt->bindParam(':modelo', $modelo);
    $stmt->bindParam(':serie', $serie);
    $stmt->bindParam(':data_entrega', $data_entrega);
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':codigo_cliente', $codigo_cliente);

    if ($stmt->execute()) {
        echo "Ordem atualizada com sucesso!";
    } else {
        echo "Erro ao atualizar a ordem.";
    }
}
?>
