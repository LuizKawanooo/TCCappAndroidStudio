

<?php
// Conexão com o banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Define o tipo MIME padrão para imagens
$mimeType = 'image/jpeg'; // Defina o tipo MIME padrão aqui

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT imagem FROM livros WHERE id = ?";

    // Prepara a consulta
    if ($stmt = $conn->prepare($sql)) {
        // Faz o bind dos parâmetros
        $stmt->bind_param("i", $id);
        
        // Executa a consulta
        $stmt->execute();
        
        // Faz o bind dos resultados
        $stmt->bind_result($imagem);
        
        // Busca os resultados
        if ($stmt->fetch()) {
            // Define o tipo de conteúdo correto
            header("Content-Type: $mimeType");
            echo $imagem;
        } else {
            echo "Nenhuma imagem encontrada.";
        }

        // Fecha a consulta
        $stmt->close();
    } else {
        // Exibe a mensagem de erro se a preparação da consulta falhar
        echo "Erro na preparação da consulta: " . $conn->error;
    }
} else {
    echo "ID não fornecido.";
}

// Fecha a conexão
$conn->close();
?>
