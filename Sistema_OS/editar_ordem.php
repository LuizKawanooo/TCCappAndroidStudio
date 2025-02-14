<?php
// Conexão com o banco de dados
$host = 'bd-os-endo.mysql.uhserver.com';
$dbname = 'bd_os_endo';
$username = 'joseendologic';
$password = '{[OSluiz2019';

// Conexão com o banco de dados
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// Verifica se a requisição é POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recebe os dados do formulário
    $codigo_cliente = $_POST["codigo_cliente"];
    $aparelho = $_POST["aparelho"];
    $marca = $_POST["marca"];
    $modelo = $_POST["modelo"];
    $serie = $_POST["serie"];
    $data_entrega = $_POST["data_entrega"];
    $valor = $_POST["valor"];

    try {
        // Atualiza os dados na tabela
        $sql = "UPDATE ordem_servico SET 
                    aparelho = :aparelho,
                    marca = :marca,
                    modelo = :modelo,
                    serie = :serie,
                    data_entrega = :data_entrega,
                    valor = :valor
                WHERE codigo_cliente = :codigo_cliente";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":aparelho", $aparelho);
        $stmt->bindParam(":marca", $marca);
        $stmt->bindParam(":modelo", $modelo);
        $stmt->bindParam(":serie", $serie);
        $stmt->bindParam(":data_entrega", $data_entrega);
        $stmt->bindParam(":valor", $valor);
        $stmt->bindParam(":codigo_cliente", $codigo_cliente);

        $stmt->execute();

        echo "Ordem de serviço atualizada com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao atualizar ordem: " . $e->getMessage();
    }
} else {
    echo "Método inválido!";
}
?>
