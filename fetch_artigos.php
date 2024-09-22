<?php
// Configurações de cabeçalhos CORS
header('Access-Control-Allow-Origin: *'); // Permite acesso de qualquer origem
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE'); // Métodos permitidos
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Cabeçalhos permitidos
header('Content-Type: application/json'); // Tipo de conteúdo da resposta

// Conexão com o banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Consulta SQL para recuperar os artigos cadastrados
$sql = "SELECT * FROM artigos";
$result = $conn->query($sql);

// Verifica se existem artigos
if ($result->num_rows > 0) {
    // Exibe os artigos
    while ($row = $result->fetch_assoc()) {
        echo "<div class='artigo'>";
        echo "<h1>Título: " . $row["titulo"] . "</h1>";
        echo "<p>Autor: " . $row["autor"] . "</p>";
        echo "<p>Ano: " . $row["ano"] . "</p>";
        // Botão de download
        echo "<a href='uploads/" . $row["arquivo"] . "' download class='btn-download'>Download</a>";
        echo "</div>";
    }
} else {
    echo "Nenhum artigo encontrado.";
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
