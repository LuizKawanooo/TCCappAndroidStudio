<?php
try {
    // Conectando ao banco de dados
    $pdo = new PDO('mysql:host=bd-os-endo.mysql.uhserver.com;dbname=bd_os_endo', 'joseendologic', '{[OSluiz2019');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Pegando os parâmetros de busca
    $aparelho = isset($_GET['aparelho_ordem']) ? $_GET['aparelho_ordem'] : '';
    $marca = isset($_GET['marca_ordem']) ? $_GET['marca_ordem'] : '';
    $modelo = isset($_GET['modelo_ordem']) ? $_GET['modelo_ordem'] : '';

    // Construindo a consulta SQL
    $sql = "SELECT * FROM ordem_servico WHERE 1=1"; // A cláusula "WHERE 1=1" facilita a adição de filtros dinamicamente

    if ($aparelho) {
        $sql .= " AND aparelho LIKE :aparelho";
    }
    if ($marca) {
        $sql .= " AND marca LIKE :marca";
    }
    if ($modelo) {
        $sql .= " AND modelo LIKE :modelo";
    }

    // Preparando a consulta
    $stmt = $pdo->prepare($sql);

    // Bind dos parâmetros
    if ($aparelho) {
        $stmt->bindValue(':aparelho', '%' . $aparelho . '%');
    }
    if ($marca) {
        $stmt->bindValue(':marca', '%' . $marca . '%');
    }
    if ($modelo) {
        $stmt->bindValue(':modelo', '%' . $modelo . '%');
    }

    // Executando a consulta
    $stmt->execute();

    // Fetch dos resultados
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Enviando os resultados como HTML
    foreach ($rows as $row) {
        echo "<tr>
                <td>{$row['codigo_cliente']}</td>
                <td>{$row['aparelho']}</td>
                <td>{$row['marca']}</td>
                <td>{$row['modelo']}</td>
                <td>{$row['serie']}</td>
                <td>{$row['acessorios']}</td>
                <td>{$row['condicoes']}</td>
                <td>{$row['defeito_informado']}</td>
                <td>{$row['descricao_servico']}</td>
                <td>{$row['entrega']}</td>
                <td>{$row['garantia']}</td>
                <td>{$row['valor']}</td>
              </tr>";
    }

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
