// <?php
// // Conexão com o banco de dados
// $servername = "tccappionic-bd.mysql.uhserver.com";
// $username = "ionic_perfil_bd";
// $password = "{[UOLluiz2019";
// $dbname = "tccappionic_bd";

// $conn = new mysqli($servername, $username, $password, $dbname);
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// // Verifica se o formulário foi enviado para editar um artigo
// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
//     $id = $_POST['id'];
//     $titulo = $_POST['titulo'];
//     $autor = $_POST['autor'];
//     $ano = $_POST['ano'];

//     // Processa o upload do arquivo, se um novo arquivo foi enviado
//     $arquivo = NULL;
//     if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == UPLOAD_ERR_OK) {
//         if (pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION) !== 'pdf') {
//             echo "Apenas arquivos PDF são permitidos.";
//             exit();
//         }
//         $arquivo = file_get_contents($_FILES['arquivo']['tmp_name']);
//     }

//     // Atualiza os dados no banco
//     if ($arquivo !== NULL) {
//         // Atualiza também o arquivo
//         $stmt = $conn->prepare("UPDATE artigos SET titulo = ?, autor = ?, ano = ?, arquivo = ? WHERE id = ?");
//         $stmt->bind_param("ssssi", $titulo, $autor, $ano, $arquivo, $id);
//     } else {
//         // Se não há novo arquivo, atualiza apenas os outros campos
//         $stmt = $conn->prepare("UPDATE artigos SET titulo = ?, autor = ?, ano = ? WHERE id = ?");
//         $stmt->bind_param("sssi", $titulo, $autor, $ano, $id);
//     }

//     if ($stmt->execute()) {
//         header("Location: tcc.php");
//         exit();
//     } else {
//         echo "Erro ao atualizar registro: " . $conn->error;
//     }
//     $stmt->close();
// }

// $conn->close();
// ?>








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

// Verifica se o formulário foi enviado para inserir um artigo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'add') {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $ano = $_POST['ano'];

    // Processa o upload do arquivo, se um novo arquivo foi enviado
    $arquivo = NULL;
    if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == UPLOAD_ERR_OK) {
        if (pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION) !== 'pdf') {
            echo "Apenas arquivos PDF são permitidos.";
            exit();
        }
        $arquivo = file_get_contents($_FILES['arquivo']['tmp_name']);
    }

    // Insere os dados no banco
    if ($arquivo !== NULL) {
        $stmt = $conn->prepare("INSERT INTO artigos (titulo, autor, ano, arquivo) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssb", $titulo, $autor, $ano, $arquivo);
    } else {
        $stmt = $conn->prepare("INSERT INTO artigos (titulo, autor, ano) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $titulo, $autor, $ano);
    }

    if ($stmt->execute()) {
        header("Location: tcc.php");
        exit();
    } else {
        echo "Erro ao inserir registro: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
