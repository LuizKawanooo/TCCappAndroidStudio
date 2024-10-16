<?php
// Conexão com o banco de dados
$servername = "tccappionic-bd.mysql.uhserver.com";
$username = "ionic_perfil_bd";
$password = "{[UOLluiz2019";
$dbname = "tccappionic_bd";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado para adicionar um artigo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $ano = $_POST['ano'];

    // Processa o upload do arquivo
    $arquivo = NULL;
    if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == UPLOAD_ERR_OK) {
        // Verifica se o arquivo é PDF
        if (pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION) !== 'pdf') {
            echo "Apenas arquivos PDF são permitidos.";
            exit();
        }
        // Lê o conteúdo do arquivo
        $arquivo = file_get_contents($_FILES['arquivo']['tmp_name']);
    } else {
        echo "Erro no upload do arquivo.";
        exit();
    }

    // Prepara a consulta SQL para inserção
    $stmt = $conn->prepare("INSERT INTO artigos (titulo, autor, ano, arquivo) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssb", $titulo, $autor, $ano, $arquivo); // "b" para BLOB

    // Executa a consulta
    if ($stmt->execute()) {
        header("Location: tcc.php"); // Redireciona após o sucesso
        exit();
    } else {
        echo "Erro ao inserir registro: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
