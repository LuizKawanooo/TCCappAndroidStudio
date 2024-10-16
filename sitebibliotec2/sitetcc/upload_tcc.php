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

// Verifica se o formulário foi enviado para adicionar um novo artigo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add') {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $ano = $_POST['ano'];

    // Processa o upload do arquivo
    $arquivo = NULL;
    if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == UPLOAD_ERR_OK) {
        if (pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION) !== 'pdf') {
            echo "Apenas arquivos PDF são permitidos.";
            exit();
        }
        $arquivo = file_get_contents($_FILES['arquivo']['tmp_name']);
    } else {
        echo "Erro no upload do arquivo.";
        exit();
    }

    // Prepara a consulta SQL para inserção
    $stmt = $conn->prepare("INSERT INTO artigos (titulo, autor, ano, arquivo) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssb", $titulo, $autor, $ano, $arquivo); // b para BLOB

    if ($stmt->execute()) {
        header("Location: tcc.php");
        exit();
    } else {
        echo "Erro ao inserir registro: " . $conn->error;
    }
    $stmt->close();
}

// Verifica se o formulário foi enviado para excluir um artigo
if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM artigos WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: tcc.php");
        exit();
    } else {
        echo "Erro ao excluir registro: " . $conn->error;
    }
    $stmt->close();
}

$conn->close();
?>
